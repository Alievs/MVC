<?php

class UpdateController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new UpdateModel();
    }

    public function index()
    {
        if (isset($_GET['update'])) {
            $this->getOneTask();
        }
        else{
            echo 'Задача не найдена';
        }

        $this->view->render('update.tpl.php', 'base.tpl.php', $this->pageData);
    }

    public function getOneTask()
    {
        // получаем task
        $result = $this->model->getOneTask((int)$_GET['update']);
        //проверяем есть ли task
        if ($result->rowCount() > 0) {
            //массив таскa
            $this->pageData['tasks_arr'] = array();

            $row = $result->fetch(PDO::FETCH_ASSOC);
            extract($row);
            //получаем данные
            $task_item = array(
                'login' => $login,
                'email' => $email,
                'body' => html_entity_decode($body),
                'status' => $status,
                'task_id' => $id
            );
            //push'им в 'data'
            array_push($this->pageData['tasks_arr'], $task_item);
        }
        else {
            //нету task'ов
            echo 'Задача не найдена';
        }
    }
    //check if body was changed
    public function checkingBodyInDB()
    {
        $id = (int)$_POST['task_id'];
        //проверяем изменения body в базе
        $db_body = $this->model->checkBody($id);
        //проверяем есть ли результат
        if ($db_body->rowCount() > 0) {
            $row = $db_body->fetch(PDO::FETCH_ASSOC);
            extract($row);

            return $body;
        }
        else{
            return false;
        }

    }

    public function updateTask()
    {

        //проверяем права доступа
        if (isset($_SESSION['admin']))
        {
            $id = (int)$_POST['task_id'];
            $body_posted = $_POST['body'];

            //преобразуем статус
            switch ($_POST['status']){
                case $_POST['status'] === 'Не выполнено':
                    $status = 0;
                    break;
                case $_POST['status'] === 'Выполнено':
                    $status = 1;
                    break;
            }

            //check if body was changed
            $db_body = $this->checkingBodyInDB();

            //check if body was changed
            if ($body_posted !== $db_body){
                //тело задчи изменено
                $body = $body_posted;
                $this->model->update($id, $body, $status);
            }
            else{
                //тело задчи без изменений
                $this->model->updateWithOutBody($id, $status);
            }

            header('Location:/');
        }
        else{
            header('Location:/');
        }

    }

}