<?php

class LoginController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new LoginModel();
    }

    public function index()
    {
        if(!empty($_POST))
        {
            //clean data
            $login = htmlspecialchars(strip_tags(trim($_POST['login'])));
            $password = htmlspecialchars(strip_tags(trim($_POST['password'])));

            //валидация
            if ($login === '' || $password === ''){
                $this->pageData["error"] = 'Поля не могут быть пустыми';
            }
            //проверяем
            $user = $this->model->checkUserInDB($login, $password);

            //сессия для админа
            if(isset($user) && $user['role_id'] === 1)
            {
                $_SESSION['admin'] = $user['role_id'];
                header('Location:/');
            }
            //валидация
            if (empty($user)){
                $this->pageData["error2"] = "Логин и/или пароль введены неверно";

            }

        }
        else {
            $this->pageData["error"] = "";
        }

        //если админ залогинен то редиректим
        if(isset($_SESSION['admin']))
        {
            header('Location:/');
        }

        $this->view->render('login.tpl.php', 'base.tpl.php', $this->pageData);
    }



    public function logout()
    {
        unset($_SESSION['admin']);
        session_destroy();
        header('Location:/');

    }

}