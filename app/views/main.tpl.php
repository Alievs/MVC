<h1 class="text-center my-4">Добро пожаловать!</h1>


<!-- Page Content -->
<div class="container">


        <?php $sortuserlink = "?" . http_build_query(array_merge($_GET, ['sort' => $pageData['sortoption']['sortByUser']]));
        $sortemaillink = "?" . http_build_query(array_merge($_GET, ['sort' => $pageData['sortoption']['sortByEmail']]));
        $sortstatuslink = "?" . http_build_query(array_merge($_GET, ['sort' => $pageData['sortoption']['sortByStatus']])); ?>

        <div class="btn-group btn-group-lg">
        <a type="button" class="btn btn-secondary dropdown-toggle" methods="get"
           href="/main<?php echo $sortuserlink; ?>">Сортировка по
            имени</a>
        <a type="button" class="btn btn-secondary dropdown-toggle" href="/main<?php echo $sortemaillink; ?>">Сортировка
            по email</a>
        <a type="button" class="btn btn-secondary dropdown-toggle" href="/main<?php echo $sortstatuslink; ?>">Сортировка
            по статусу</a>

        <a type="button" class="btn btn-secondary green" href="/create">+ Создать задание</a>
        </div>

    <?php foreach ($pageData['tasks_arr'] as $arr_item) : ?>

        <!-- Tasks -->
        <form class="form-signin blank">
            <div class="form-group inp-line">
                <label for="Email">Email:</label>
                <div id="Email" class="ml-1"><?php echo $arr_item['email']; ?></div>

                <label class="ml-4" for="Login">Имя:</label>
                <div id="Login" class="ml-1"><?php echo $arr_item['login']; ?></div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <span class="pl-5 article-details float-right">
                        <?php if ($arr_item['status'] === 0) : ?>
                            <p style="color:red"><?php echo 'Не выполнено'; ?></p>
                        <?php elseif ($arr_item['status'] === 1) : ?>
                            <p style="color:green"><?php echo 'Выполнено'; ?></p>
                        <?php endif; ?>
                    </span>

                    <?php if ($arr_item['updated'] !== null) : ?>
                        <span class="pl-5 article-details float-right">Oтредактировано администратором</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="Body">Текст задачи</label>
                <textarea class="form-control" name="body" id="Body" rows="10" disabled><?php echo $arr_item['body']; ?></textarea>
            </div>

            <?php if (isset($_SESSION['admin'])) : ?>
                <div class="form-actions text-center">
                    <a type="submit" class="btn btn-secondary btn-sm ml-2" href="/main/update<?php echo "?".http_build_query(array_merge($_GET, ['update' => $arr_item['task_id']]));?>">Редактировать</a>
                </div>
            <?php endif; ?>
        </form>


    <?php endforeach; ?>
    <!--    пагинация        -->
    <nav aria-label='Page navigation'>
        <ul class='pagination'>
            <li><a class="page-link" href='/main<?php echo "?" . http_build_query(array_merge($_GET, ['page' => 1])); ?>' aria-label='Previous'><span aria-hidden='true'>&laquo;</span> Начало</a></li>
            <?php for($i=2; $i<=($pageData['limitPages']['totalPages'])-1; $i++) : ?>
                <li><a class="page-link" href='/main<?php echo "?" . http_build_query(array_merge($_GET, ['page' => $i])); ?>'><?php echo $i; ?></a></li>
            <?php endfor; ?>
            <li><a class="page-link" href='/main<?php echo "?" . http_build_query(array_merge($_GET, ['page' => ($pageData['limitPages']['totalPages'])])); ?>' aria-label='Next'>Конец <span aria-hidden='true'>&raquo;</span></a></li>
        </ul>

