<?php

class CreateController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new CreateModel();
    }

    public function index()
    {
        if (!empty($_POST)){

            $login = $_POST['login'];
            $email =$_POST['email'];
            $body =$_POST['body'];

            //валидация
            $clear_data = $this->validation($login, $email, $body);

            //clean data
            $login = htmlspecialchars(strip_tags(trim($login)));
            $email = htmlspecialchars(strip_tags(trim($email)));
            $body = htmlspecialchars(strip_tags(trim($body)));


            if (!isset($clear_data['error'])) {
                //проверяем наличие юзера в базе
                $user_id = $this->model->checkUser($login, $email);

                if ($user_id !== null) {
                    // если юзер есть, то создаём таск с его id
                    $this->createTask($user_id, $body);
                }
                else {
                    // или создаём таск с новым юзером
                    $this->createTaskWithNewUser($login, $email, $body);
                }
            }

        }

        $this->view->render('create.tpl.php', 'base.tpl.php', $this->pageData);
    }

    public function validation($login, $email, $body) {
        //валидация
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        } else {
            //флаг для валидации
            $this->pageData["error"] = 'Email введен неверно';
        }
        if (trim($login) == '' || trim($email) == '' || trim($body) == '')
        {
            //флаг для валидации
            $this->pageData["error"] = 'Поля не могут быть пустыми';
        }
        return $this->pageData ;
    }

    // если юзер есть, то создаём таск с его id
    public function createTask($user_id, $body)
    {
        if ($this->model->createTask($user_id, $body)){
            //флаг для обратной связи
            $this->pageData['task'] = 'Задача опубликована';
        }
        else{
            //флаг для обратной связи
            $this->pageData['error'] = 'Задача не создана';
        }
        
        return $this->pageData ;
    }

    // или создаём таск с новым юзером
    public function createTaskWithNewUser ($login, $email, $body)
    {
        if ($this->model->createTaskWithNewUser($login, $email, $body, $password = '', $role_id = 2)){
            $this->pageData['task'] = 'Задача опубликована';
        }
        else{
            //флаг для обратной связи
            $this->pageData['error'] = 'Задача не создана';
        }
        
        return $this->pageData ;
    }

}