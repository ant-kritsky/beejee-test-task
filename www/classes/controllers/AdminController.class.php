<?php

/**
 * Класс контроллера Index
 * @author Anton Kritsky <admin@delca.ru>
 */
class AdminController extends Controller
{
    /**
     * Экшен профиля
     * если не авторизован - рендерим форму авторизации
     */
    public function indexAction()
    {
        if ($this->auth->isAuth()) {
            header('Location: /');
        } else {
            $this->view->render('login.php', true);
        }
    }

    /**
     * Экшен авторизации
     */
    public function loginAction()
    {
        if (isset($_POST['password']) and isset($_POST['login'])) {
            $login = trim($_POST['login']);
            $password = md5(trim($_POST['password']));

            if ($this->auth->doAuth($login, $password)) {
                // Если авторизация прошла редиректим на главную
                header('Location: /');
            } else {
                $this->view->set('error', $_SESSION['error']);
                unset($_SESSION['error']);
            }

        }

        $this->view->render('login.php', true);
    }

    /**
     * Экшен выхода пользователя из профиля
     */
    public function logoutAction()
    {
        $this->auth->out();
        header('Location: /');
    }

}