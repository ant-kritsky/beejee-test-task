<?php

/**
 * Класс контроллера Index
 * @author Anton Kritsky <admin@delca.ru>
 */
class IndexController extends Controller
{
    private $tasksPerPage = 3;

    const DEFAULT_SORT = 'status';

    /**
     * Список заданий
     */
    public function indexAction()
    {
        $page = $_GET['page'] ?? 1;
        $model = new Task();
        $tasks = $model->getAll($this->tasksPerPage, $this->getSort(), $page);

        $this->view->set('page', $page);
        $this->view->set('tasks', $tasks);
        $this->view->set('pages', ceil($model->getCount() / $this->tasksPerPage));


        if (!empty($_SESSION["info"])) {
            $this->view->set('info', $_SESSION['info']);
            unset($_SESSION['info']);
        }

        $this->view->render('index.php', true);
    }

    /**
     * Завершить задание
     */
    public function doneAction()
    {
        if ($this->auth->isAuth()) {
            $id = $_GET['id'] ?? null;

            if (is_numeric($id)) {
                Task::getInstance()->done($id);
                $_SESSION["info"] = 'Task was done!';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
    }

    /**
     * Завершить задание
     */
    public function updateAction()
    {
        if ($this->auth->isAuth()) {
            $id = $_POST['id'] ?? null;

            if (is_numeric($id) && isset($_POST['text'])) {
                $text = htmlspecialchars($_POST['text']);
                Task::getInstance()->update($id, $text, $this->auth->getUser()->id);
                $task = Task::getInstance()->get($id);
                $_SESSION["info"] = 'Task was updated!';

                echo json_encode([
                    'status' => 'success',
                    'text' => $this->view->getDescription($task)
                ]);
                exit;
            }
        }
    }

    /**
     * Возвращает строку сортировки.
     */
    public function getSort()
    {
        $order = isset($_GET['order']) && in_array($_GET['order'], $this->view->sortFields) ? $_GET['order'] : self::DEFAULT_SORT;
        $this->view->set('order', $order);

        $orderBy = (isset($_GET['orderBy']) && $_GET['orderBy'] == 'DESC' ? $_GET['orderBy'] : 'ASC');
        $this->view->set('orderBy', $orderBy);

        return "$order $orderBy";
    }

    /**
     * Добавление задания
     */
    public function addAction()
    {
        $errors = [];

        if (isset($_POST['description']) or isset($_POST['email']) or isset($_POST['description'])) {
            $name = htmlspecialchars(trim($_POST['name']));
            $email = htmlspecialchars(trim($_POST['email']));
            $description = htmlspecialchars(trim($_POST['description']));
            $this->view->set('name', $name);
            $this->view->set('email', $email);
            $this->view->set('description', $description);

            // Валидация email
            $mailPattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
            if (!preg_match($mailPattern, $email)) {
                $errors['email'] = _("Please enter a valid email address.");
            }

            $minMessage = _("Please enter no more than {0} characters.");
            $maxMessage = _("Please enter at least {0} characters.");

            // Валидация имени
            $name_length = mb_strlen($name);
            if ($name_length < 3) {
                $errors['name'] = str_replace('{0}', 3, $maxMessage);
            }
            if ($name_length > 150) {
                $errors['name'] = str_replace('{0}', 150, $minMessage);
            }

            // Валидация текста задания
            $description_length = mb_strlen($description);
            if ($description_length < 3) {
                $errors['description'] = str_replace('{0}', 3, $maxMessage);
            }
            if ($description_length > 500) {
                $errors['description'] = str_replace('{0}', 500, $minMessage);
            }

            if (count($errors) == 0) {
                $task = new Task();

                if ($id = $task->add($name, $email, $description)) {
                    $_SESSION["info"] = 'Task was added!';
                    header('Location: ' . Core::getInstance()->getBaseURL());
                }
            }
        }

        $this->view->set('errors', $errors);
        $this->view->render('add.php', true);
    }


}