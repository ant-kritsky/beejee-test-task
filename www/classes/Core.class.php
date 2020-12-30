<?php

/**
 * Класс ядра
 * @author Anton Kritsky <admin@delca.ru>
 */
class Core
{
    const DEFAULT_CONTROLLER = 'Index';
    const DEFAULT_ACTION = 'index';
    const CONTROLLER_SUFFIX = 'Controller';
    const ACTION_SUFFIX = 'Action';

    protected $_db = null;
    protected $_auth = null;

    protected static $_instance;

    public $controllerName;
    public $actionName;

    /**
     * приватный конструктор для ограничения реализации getInstance ()
     */
    private function __construct()
    {
    }

    /**
     * Возвращает объект ядра
     * @return Core
     */
    public static function getInstance()
    {
        global $db_conf;

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
            self::$_instance->_db = new PDO($db_conf['dsn'], $db_conf['user'], $db_conf['password']);
            self::$_instance->_auth = new Auth();
        }

        return self::$_instance;
    }

    /**
     * Выполнение текущего экшена, нужного контроллера
     */
    public function run()
    {
        $this->route();

        $controller = new $this->controllerName;

        return $controller->{$this->actionName}();
    }


    /**
     * Маршрутизация адреса
     *
     * Разбивает текущий УРЛ на /$locale/$controller/$action
     */
    public function route()
    {
        $requestUrl = $_SERVER['REQUEST_URI'];
        $requestString = current(explode('?', $requestUrl));

        $urlParams = explode('/', $requestString);
        array_shift($urlParams);
        $path = array_shift($urlParams);
        $controllerName = ucfirst($path);

        if (!$controllerName) {
            $controllerName = self::DEFAULT_CONTROLLER;
        }

        $controllerName .= self::CONTROLLER_SUFFIX;

        $actionName = strtolower(array_shift($urlParams));

        // Если экшн не указан
        if (!$actionName) {
            // И есть контроллер для первого параметра в адресе
            if (class_exists($controllerName)) {
                $actionName = self::DEFAULT_ACTION;
            } else {
                // Иначе первый параметр является экшеном для index контроллера
                $actionName = strtolower(str_replace(self::CONTROLLER_SUFFIX, '', $controllerName));
                $controllerName = self::DEFAULT_CONTROLLER . self::CONTROLLER_SUFFIX;
            }
        }

        $actionName .= self::ACTION_SUFFIX;

        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
    }

    /**
     * Возвращает объект PDO
     * @return  PDO
     */
    public function getDb()
    {
        return self::$_instance->_db;
    }


    /**
     * Возвращает объект авторизации
     * @return Auth
     */
    public function getAuth()
    {
        return self::$_instance->_auth;
    }

    /**
     * Заглушка для синглтона
     */
    private function __clone()
    {

    }

    public static function __autoload($className)
    {
        $directories = [
            CLASSES_DIR,
            MODEL_DIR,
            CONTROLLERS_DIR
        ];

        foreach ($directories as $directory) {
            $path = $directory . $className . '.class.php';

            if (file_exists($path)) {
                require_once($path);

                return true;
            }
        }

        return false;
    }
}