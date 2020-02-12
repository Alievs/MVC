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
        $sort_variant = 'ASC';
        $sort_column = 'u.login';
        $sort = array(
            'sortByUser' => 'sortByUsernameDESC',
            'sortByEmail' => 'sortByEmailDESC',
            'sortByStatus' => 'sortByStatusDESC',
        );
        $this->pageData['sortoption'] = $sort;



        if (!isset($_GET['sort'])) {
            $this->sortByColumnWithLimit($sort_variant, $sort_column);
        } else {
            // меняем сортировку в кнопках & выводим отсортированные данные
            switch (isset($_GET['sort'])):
                case $_GET['sort'] === 'sortByUsernameASC':

                    $this->pageData['sortoption']['sortByUser'] = 'sortByUsernameDESC';
                    $this->sortByColumnWithLimit($sort_variant, $sort_column);
                    break;
                case $_GET['sort'] === 'sortByUsernameDESC':

                    $this->pageData['sortoption']['sortByUser'] = 'sortByUsernameASC';
                    $this->sortByColumnWithLimit($sort_variant = 'DESC', $sort_column);
                    break;
                case $_GET['sort'] === 'sortByEmailASC':

                    $this->pageData['sortoption']['sortByEmail'] = 'sortByEmailDESC';
                    $this->sortByColumnWithLimit($sort_variant, $sort_column = 'u.email');
                    break;
                case $_GET['sort'] === 'sortByEmailDESC':

                    $this->pageData['sortoption']['sortByEmail'] = 'sortByEmailASC';
                    $this->sortByColumnWithLimit($sort_variant = 'DESC', $sort_column = 'u.email');
                    break;
                case $_GET['sort'] === 'sortByStatusASC':

                    $this->pageData['sortoption']['sortByStatus'] = 'sortByStatusDESC';
                    $this->sortByColumnWithLimit($sort_variant, $sort_column = 't.status');
                    break;
                case $_GET['sort'] === 'sortByStatusDESC':

                    $this->pageData['sortoption']['sortByStatus'] = 'sortByStatusASC';
                    $this->sortByColumnWithLimit($sort_variant = 'DESC', $sort_column = 't.status');
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

        $limits = array(
            'limit' => $limit,
            'offset' => $offset
        );

        // для пагинатора во view
        $this->pageData['totalPages'] = $totalPages;

        // возвращаем данные для методов сортировки
        return $limits;
    }

    public function sortByColumnWithLimit($sort_variant, $sort_column)
    {
        //кол-во результатов
        $num = $this->model->countOfTasks();
        //кол-во страниц
        $totalPages = ceil($num / $this->taskPerPage);

        // определяем страницу & кол-во task'ов которое будет выведено
        $pages = $this->makeTaskPager($num, $totalPages);
        $limit = (int)$pages['limit'];
        $offset = (int)$pages['offset'];

        // получаем tasks sort by username ASC
        $result = $this->model->sortByColumnWithLimit($limit, $offset, $sort_variant, $sort_column);
        //кол-во результатов
        $num = $result->rowCount();

        //достаём task'и из результирующей выборки
        $this->fetchAllData($num, $result);

        $this->view->render('main.tpl.php', 'base.tpl.php', $this->pageData);

    }

    //достаём task'и из результирующей выборки
    public function fetchAllData($num, $result)
    {
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
    }
}