<?php


class MainController extends Controller
{
    //лимит task'ов
    private $taskPerPage = 3;

    public function __construct()
    {
        parent::__construct();
        $this->model = new MainModel();
        $this->utils = new Utils();
    }


    public function index()
    {
        //сортировка по дефолту
        $sort = array(
            'sortByUser' => 'sortByUsernameWithLimitASC',
            'sortByEmail' => 'sortByEmailWithLimitASC',
            'sortByStatus' => 'sortByStatusWithLimitASC',
        );
        $this->pageData['sortoption'] = $sort;

        if (!isset($_GET['sort'])) {
            $this->sortByUsernameWithLimitASC();
        } else {
            // меняем сортировку в кнопках & выводим отсортированные данные
            switch (isset($_GET['sort'])):
                case $_GET['sort'] === 'sortByUsernameWithLimitASC':
                    $this->pageData['sortoption']['sortByUser'] = 'sortByUsernameWithLimitDESC';
                    $this->sortByUsernameWithLimitASC();
                    break;
                case $_GET['sort'] === 'sortByUsernameWithLimitDESC':
                    $this->pageData['sortoption']['sortByUser'] = 'sortByUsernameWithLimitASC';
                    $this->sortByUsernameWithLimitDESC();
                    break;
                case $_GET['sort'] === 'sortByEmailWithLimitASC':
                    $this->pageData['sortoption']['sortByEmail'] = 'sortByEmailWithLimitDESC';
                    $this->sortByEmailWithLimitASC();
                    break;
                case $_GET['sort'] === 'sortByEmailWithLimitDESC':
                    $this->pageData['sortoption']['sortByEmail'] = 'sortByEmailWithLimitASC';
                    $this->sortByEmailWithLimitDESC();
                    break;
                case $_GET['sort'] === 'sortByStatusWithLimitASC':
                    $this->pageData['sortoption']['sortByStatus'] = 'sortByStatusWithLimitDESC';
                    $this->sortByStatusWithLimitASC();
                    break;
                case $_GET['sort'] === 'sortByStatusWithLimitDESC':
                    $this->pageData['sortoption']['sortByStatus'] = 'sortByStatusWithLimitASC';
                    $this->sortByStatusWithLimitDESC();
                    break;
            endswitch;
        }
    }

    // определяем страницу & кол-во task'ов которое будет выведено
    public function makeTaskPager($num, $totalPages)
    {
        if (!isset($_GET['page']) || (int)$_GET['page'] <= 1) {
            $pageNumber = 1;
            $limit = 0;//leftlimit
            $offset = $this->taskPerPage;//rightlimit
        } elseif ((int)($_GET['page']) > $totalPages || (int)($_GET['page']) == $totalPages) {
            $pageNumber = $totalPages;
            $limit = $this->taskPerPage * ($pageNumber - 1);//leftlimit
            $offset = $num;//rightlimit

        } else {
            $pageNumber = (int)$_GET['page'];
            $limit = $this->taskPerPage * ($pageNumber - 1);//leftlimit
            $offset = $this->taskPerPage;//rightlimit
        }

        $page_item = array(
            'pageNumber' => $pageNumber,//для гет запроса
            'totalPages' => $totalPages,
            'limit' => $limit,
            'offset' => $offset
        );

        // для пагинатора во view
        $this->pageData['limitPages'] = $page_item;

        // возвращаем данные для методов сортировки
        return $page_item;
    }

    public function sortByUsernameWithLimitASC()
    {
        // не самое лучшее решение , но пока оставлю чтоб выводить на кнопки сортировку
        $allResult = $this->model->sortByNewest();
        //кол-во результатов
        $num = $allResult->rowCount();
        //кол-во страниц
        $totalPages = ceil($num / $this->taskPerPage);

        // определяем страницу & кол-во task'ов которое будет выведено
        $pages = $this->makeTaskPager($num, $totalPages);
        $limit = (int)$pages['limit'];
        $offset = (int)$pages['offset'];

        //пагинация
        $pagination = $this->utils->drawPager($num, $this->taskPerPage);
        $this->pageData['pagination'] = $pagination;


        // получаем tasks sort by username ASC
        $result = $this->model->sortByUsernameWithLimitASC($limit, $offset);
        //кол-во результатов
        $num = $result->rowCount();

        //проверяем есть ли tasks
        if ($num > 0) {
            //массив тасков
            $this->pageData['tasks_arr'] = array();

            //перебериаем $result
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $task_item = array(
                    'login' => $login,
                    'email' => $email,
                    'body' => html_entity_decode($body),
                    'status' => $status,
                    'updated' => $updated_at,
                    'task_id' => $id
                );
                //push'им в 'data'
                array_push($this->pageData['tasks_arr'], $task_item);
            }

        } else {
            //нету task'ов
            echo 'Задачи не найдены';
        }
        $this->view->render('main.tpl.php', 'base.tpl.php', $this->pageData);
    }

    public function sortByUsernameWithLimitDESC()
    {
        // не самое лучшее решение , но пока оставлю чтоб выводить на кнопки сортировку
        $allResult = $this->model->sortByNewest();
        //кол-во результатов
        $num = $allResult->rowCount();
        //кол-во страниц
        $totalPages = ceil($num / $this->taskPerPage);

        // определяем страницу & кол-во task'ов которое будет выведено
        $pages = $this->makeTaskPager($num, $totalPages);
        $limit = (int)$pages['limit'];
        $offset = (int)$pages['offset'];

        //пагинация
        $pagination = $this->utils->drawPager($num, $this->taskPerPage);
        $this->pageData['pagination'] = $pagination;

        // получаем tasks sort by username ASC
        $result = $this->model->sortByUsernameWithLimitDESC($limit, $offset);
        //кол-во результатов
        $num = $result->rowCount();

        //проверяем есть ли tasks
        if ($num > 0) {
            //массив тасков
            $this->pageData['tasks_arr'] = array();

            //перебериаем $result
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $task_item = array(
                    'login' => $login,
                    'email' => $email,
                    'body' => html_entity_decode($body),
                    'task_id' => $id,
                    'status' => $status,
                    'updated' => $updated_at
                );
                //push'им в 'data'
                array_push($this->pageData['tasks_arr'], $task_item);
            }

        } else {
            //нету task'ов
            echo 'Задачи не найдены';
        }
        $this->view->render('main.tpl.php', 'base.tpl.php', $this->pageData);
    }

    public function sortByEmailWithLimitASC()
    {
        // не самое лучшее решение , но пока оставлю чтоб выводить на кнопки сортировку
        $allResult = $this->model->sortByNewest();
        //кол-во результатов
        $num = $allResult->rowCount();
        //кол-во страниц
        $totalPages = ceil($num / $this->taskPerPage);

        //пагинация
        $pagination = $this->utils->drawPager($num, $this->taskPerPage);
        $this->pageData['pagination'] = $pagination;

        // определяем страницу & кол-во task'ов которое будет выведено
        $pages = $this->makeTaskPager($num, $totalPages);
        $limit = (int)$pages['limit'];
        $offset = (int)$pages['offset'];

        // получаем tasks sort by username ASC
        $result = $this->model->sortByEmailWithLimitASC($limit, $offset);
        //кол-во результатов
        $num = $result->rowCount();

        //проверяем есть ли tasks
        if ($num > 0) {
            //массив тасков
            $this->pageData['tasks_arr'] = array();

            //перебериаем $result
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $task_item = array(
                    'login' => $login,
                    'email' => $email,
                    'body' => html_entity_decode($body),
                    'task_id' => $id,
                    'status' => $status,
                    'updated' => $updated_at
                );
                //push'им в 'data'
                array_push($this->pageData['tasks_arr'], $task_item);
            }

        } else {
            //нету task'ов
            echo 'Задачи не найдены';
        }
        $this->view->render('main.tpl.php', 'base.tpl.php', $this->pageData);
    }

    public function sortByEmailWithLimitDESC()
    {
        // не самое лучшее решение , но пока оставлю чтоб выводить на кнопки сортировку
        $allResult = $this->model->sortByNewest();
        //кол-во результатов
        $num = $allResult->rowCount();
        //кол-во страниц
        $totalPages = ceil($num / $this->taskPerPage);

        //пагинация
        $pagination = $this->utils->drawPager($num, $this->taskPerPage);
        $this->pageData['pagination'] = $pagination;

        // определяем страницу & кол-во task'ов которое будет выведено
        $pages = $this->makeTaskPager($num, $totalPages);
        $limit = (int)$pages['limit'];
        $offset = (int)$pages['offset'];

        // получаем tasks sort by username ASC
        $result = $this->model->sortByEmailWithLimitDESC($limit, $offset);
        //кол-во результатов
        $num = $result->rowCount();

        //проверяем есть ли tasks
        if ($num > 0) {
            //массив тасков
            $this->pageData['tasks_arr'] = array();

            //перебериаем $result
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $task_item = array(
                    'login' => $login,
                    'email' => $email,
                    'body' => html_entity_decode($body),
                    'task_id' => $id,
                    'status' => $status,
                    'updated' => $updated_at
                );
                //push'им в 'data'
                array_push($this->pageData['tasks_arr'], $task_item);
            }

        } else {
            //нету task'ов
            echo 'Задачи не найдены';
        }
        $this->view->render('main.tpl.php', 'base.tpl.php', $this->pageData);
    }

    public function sortByStatusWithLimitASC()
    {
        // не самое лучшее решение , но пока оставлю чтоб выводить на кнопки сортировку
        $allResult = $this->model->sortByNewest();
        //кол-во результатов
        $num = $allResult->rowCount();
        //кол-во страниц
        $totalPages = ceil($num / $this->taskPerPage);

        //пагинация
        $pagination = $this->utils->drawPager($num, $this->taskPerPage);
        $this->pageData['pagination'] = $pagination;

        // определяем страницу & кол-во task'ов которое будет выведено
        $pages = $this->makeTaskPager($num, $totalPages);
        $limit = (int)$pages['limit'];
        $offset = (int)$pages['offset'];

        // получаем tasks sort by username ASC
        $result = $this->model->sortByStatusWithLimitASC($limit, $offset);
        //кол-во результатов
        $num = $result->rowCount();

        //проверяем есть ли tasks
        if ($num > 0) {
            //массив тасков
            $this->pageData['tasks_arr'] = array();

            //перебериаем $result
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $task_item = array(
                    'login' => $login,
                    'email' => $email,
                    'body' => html_entity_decode($body),
                    'task_id' => $id,
                    'status' => $status,
                    'updated' => $updated_at
                );
                //push'им в 'data'
                array_push($this->pageData['tasks_arr'], $task_item);
            }

        } else {
            //нету task'ов
            echo 'Задачи не найдены';
        }
        $this->view->render('main.tpl.php', 'base.tpl.php', $this->pageData);
    }

    public function sortByStatusWithLimitDESC()
    {
        // не самое лучшее решение , но пока оставлю чтоб выводить на кнопки сортировку
        $allResult = $this->model->sortByNewest();
        //кол-во результатов
        $num = $allResult->rowCount();
        //кол-во страниц
        $totalPages = ceil($num / $this->taskPerPage);

        //пагинация
        $pagination = $this->utils->drawPager($num, $this->taskPerPage);
        $this->pageData['pagination'] = $pagination;

        // определяем страницу & кол-во task'ов которое будет выведено
        $pages = $this->makeTaskPager($num, $totalPages);
        $limit = (int)$pages['limit'];
        $offset = (int)$pages['offset'];

        // получаем tasks sort by username ASC
        $result = $this->model->sortByStatusWithLimitDESC($limit, $offset);
        //кол-во результатов
        $num = $result->rowCount();

        //проверяем есть ли tasks
        if ($num > 0) {
            //массив тасков
            $this->pageData['tasks_arr'] = array();

            //перебериаем $result
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $task_item = array(
                    'login' => $login,
                    'email' => $email,
                    'body' => html_entity_decode($body),
                    'task_id' => $id,
                    'status' => $status,
                    'updated' => $updated_at
                );
                //push'им в 'data'
                array_push($this->pageData['tasks_arr'], $task_item);
            }

        } else {
            //нету task'ов
            echo 'Задачи не найдены';
        }
        $this->view->render('main.tpl.php', 'base.tpl.php', $this->pageData);
    }


}