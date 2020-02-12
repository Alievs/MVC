<?php
class Utils
{

    // общее кол-во элементов & кол-во элементов на одной странице
    public function drawPager($totalItems, $perPage) {
        //округляем для определения количества страниц
        $pages = ceil($totalItems / $perPage);

        // определяем страницу
        if(!isset($_GET['page']) || (int)$_GET['page'] == 0) {
            $page = 1;
        } elseif((int)$_GET['page'] > $totalItems) {
            $page = $pages;
        } else {
            $page = (int)$_GET['page'];
        }

        $pglink = "?" . http_build_query(array_merge($_GET, ['page' => 1]));
        $pglinks = "?" . http_build_query(array_merge($_GET, ['page' => $pages]));
        //отрисовываем paginator
        $pager =  "<nav aria-label='Page navigation'>";
        $pager .= "<ul class='pagination'>";
        $pager .= "<li><a class=\"page-link\" href='/main". $pglink ."' aria-label='Previous'><span aria-hidden='true'>&laquo;</span> Начало</a></li>";
        for($i=2; $i<=$pages-1; $i++) {
            $pager .= "<li><a class=\"page-link\" href='/main". "?" . http_build_query(array_merge($_GET, ['page' => $i]))."'>" . $i ."</a></li>";
        }
        $pager .= "<li><a class=\"page-link\" href='/main". $pglinks ."' aria-label='Next'>Конец <span aria-hidden='true'>&raquo;</span></a></li>";
        $pager .= "</ul>";

        return $pager;

    }


}