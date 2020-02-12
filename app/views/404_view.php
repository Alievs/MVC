<h1>404</h1>
<p>
    <img src="/images/404_page_cover.jpg">
</p>

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

    $pglink = "?" . http_build_query(array_merge($_GET, ['page' => 1]));
    $pglinks = "?" . http_build_query(array_merge($_GET, ['page' => $pages]));
    //отрисовываем paginator

<nav aria-label='Page navigation'>
<ul class='pagination'>
<li><a class="page-link" href='/main<?php echo "?" . http_build_query(array_merge($_GET, ['page' => 1])); ?>' aria-label='Previous'><span aria-hidden='true'>&laquo;</span> Начало</a></li>
    <?php for($i=2; $i<=$pages-1; $i++) : ?>
<li><a class="page-link" href='/main<?php echo "?" . http_build_query(array_merge($_GET, ['page' => $i])); ?>'><?php echo $i; ?></a></li>
    <?php endfor; ?>
<li><a class="page-link" href='/main<?php echo "?" . http_build_query(array_merge($_GET, ['page' => $pages])); ?>' aria-label='Next'>Конец <span aria-hidden='true'>&raquo;</span></a></li>
</ul>
