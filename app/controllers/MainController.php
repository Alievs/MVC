<?php


class MainController extends Controller
{
    //лимит task'ов
    private $taskPerPage = 3;

    public function __construct()
    {
        parent::__construct();
        $this->model = new MainModel();
    }


    public function index()
    {
        //сортировка по дефолту
        $sort_option = 'ASC';
        $sort = array(
            'sortByUser' => 'sortByUsernameWithLimitASC',
            'sortByEmail' => 'sortByEmailWithLimitASC',
            'sortByStatus' => 'sortByStatusWithLimitASC',
        );
        $this->pageData['sortoption'] = $sort;

        if (!isset($_GET['sort'])) {
            $this->sortByUsernameWithLimit($sort_option);
        } else {
            // меняем сортировку в кнопках & выводим отсортированные данные
            switch (isset($_GET['sort'])):
                case $_GET['sort'] === 'sortByUsernameWithLimitASC':
                    $this->pageData['sortoption']['sortByUser'] = 'sortByUsernameWithLimitDESC';
                    $this->sortByUsernameWithLimit($sort_option);
                    break;
                case $_GET['sort'] === 'sortByUsernameWithLimitDESC':
                    $this->pageData['sortoption']['sortByUser'] = 'sortByUsernameWithLimitASC';
                    $this->sortByUsernameWithLimit($sort_option = 'DESC');
                    break;
                case $_GET['sort'] === 'sortByEmailWithLimitASC':
                    $this->pageData['sortoption']['sortByEmail'] = 'sortByEmailWithLimitDESC';
                    $this->sortByEmailWithLimit($sort_option);
                    break;
                case $_GET['sort'] === 'sortByEmailWithLimitDESC':
                    $this->pageData['sortoption']['sortByEmail'] = 'sortByEmailWithLimitASC';
                    $this->sortByEmailWithLimit($sort_option = 'DESC');
                    break;
                case $_GET['sort'] === 'sortByStatusWithLimitASC':
                    $this->pageData['sortoption']['sortByStatus'] = 'sortByStatusWithLimitDESC';
                    $this->sortByStatusWithLimit($sort_option);
                    break;
                case $_GET['sort'] === 'sortByStatusWithLimitDESC':
                    $this->pageData['sortoption']['sortByStatus'] = 'sortByStatusWithLimitASC';
                    $this->sortByStatusWithLimit($sort_option = 'DESC');
                    break;
            endswitch;
        }
    }

    // определяем страницу & кол-во task'ов которое будет выведено
    public function makeTaskPager($num, $totalPages)
    {
        //если страница не указана или минусовая :
        if (!isset($_GET['page']) || (int)$_GET['page'] <= 1) {
            $pageNumber = 1;
            $limit = 0;//leftlimit
            $offset = $this->taskPerPage;//rightlimit
        }
        //если страница больше общего кол-ва или равняется ему :
        elseif ((int)($_GET['page']) > $totalPages || (int)($_GET['page']) == $totalPages) {
            $pageNumber = $totalPages;
            $limit = $this->taskPerPage * ($pageNumber - 1);//leftlimit
            $offset = $num;//rightlimit

        }
        else {
            $pageNumber = (int)$_GET['page'];
            $limit = $this->taskPerPage * ($pageNumber - 1);//leftlimit
            $offset = $this->taskPerPage;//rightlimit
        }

        $page_item = array(
            'pageNumber' => $pageNumber,//для гет запроса
            'totalPages' => $totalPages,//для пагинации
            'limit' => $limit,
            'offset' => $offset
        );

        // для пагинатора во view
        $this->pageData['limitPages'] = $page_item;

        // возвращаем данные для методов сортировки
        return $page_item;
    }

    public function sortByUsernameWithLimit($sort_option)
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

        // получаем tasks sort by username ASC
        $result = $this->model->sortByUsernameWithLimit($limit, $offset, $sort_option);
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

    public function sortByEmailWithLimit($sort_option)
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

        // получаем tasks sort by username ASC
        $result = $this->model->sortByEmailWithLimit($limit, $offset, $sort_option);
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

    public function sortByStatusWithLimit($sort_option)
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

        // получаем tasks sort by username ASC
        $result = $this->model->sortByStatusWithLimitASC($limit, $offset, $sort_option);
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