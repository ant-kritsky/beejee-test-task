<?php

/**
 * Класс шаблонизатора
 * @author Anton Kritsky <admin@delca.ru>
 */
class View
{
    private $_path;
    private $_template;
    private $_var = [];

    public $baseURL = null;
    public $sortFields = ['name', 'email', 'status'];

    public function __construct($path = '')
    {
        $this->_path = $path;
        $this->baseURL = Core::getInstance()->getBaseURL();
    }

    /**
     * Сеттер переменных шаблона
     * @param Ключ переменной
     * @param Значение переменной
     */
    public function set($name, $value)
    {
        $this->_var[$name] = $value;
    }

    /**
     * Геттер переменных шаблона
     * @param ключ переменной
     */
    public function get($name)
    {
        if (isset($this->_var[$name])) {
            return $this->_var[$name];
        }

        return '';
    }

    /**
     * Возвращает ссылку сортировки по полю.
     *
     * @param $name
     * @param $label
     * @return string
     */
    public function sortLink($name, $label)
    {
        if (!in_array($name, $this->sortFields)) {
            return $label;
        }

        $order = $this->get('order');
        $orderBy = $this->get('orderBy');

        $href = "?order=$name";
        $symbol = '&uarr;';
        $class = '';

        if ($order == $name) {
            $class = 'active';
            $href .= '&orderBy=' . ($orderBy == 'ASC' ? 'DESC' : 'ASC');

            if ($orderBy == 'ASC') {
                $symbol = '&darr;';
            }

            if ($page = $this->get('page')) {
                $href .= '&page=' . $page;
            }
        }

        return "<a class=\"$class\" href=\"$href\">$label $symbol</a>";
    }

    /**
     * Рендеринг шаблона
     * @param Имя шаблона
     * @param Использовать лайаут или нет
     */
    public function render($template, $layout = false)
    {
        $this->_template = $this->_path . $template;

        if (!file_exists($this->_template)) {
            throw new Exception('Template ' . $this->_template . ' not exist!');
        }

        $auth = new Auth();

        ob_start();
        include($this->_template);
        $content = ob_get_clean();

        if ($layout) {
            include($this->_path . "layout.php");
        } else {
            echo $content;
        }
    }

}