<?php

/**
 * Класс родитель контроллеров
 * @author Anton Kritsky <admin@delca.ru>
 */
class Controller
{
    public $view = null;
    public $auth = null;

    public function __construct()
    {
        global $core;
        $this->view = new View(TEMPLATE_DIR);
        $this->auth = $core->getAuth();
    }
}