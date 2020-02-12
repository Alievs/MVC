
<?php foreach ($pageData['tasks_arr'] as $arr_item) : ?>


    <!-- Tasks -->
    <?php if (!isset($_SESSION['admin'])) : ?>
    <?php header('Location:/'); ?>
    <?php endif; ?>

    <form action="/update/updateTask" style="max-width: 500px" id="taskform" class="form-signin blank" method="post">
    <div class="form-group">
        <label for="Email">Email</label>
        <input type="email" name="email" class="form-control" id="Email"
               placeholder="<?php echo $arr_item['email']; ?>" disabled>
    </div>
    <div class="form-group">
        <label for="Login">Имя</label>
        <input type="email" class="form-control" name="login" id="Login"
               placeholder="<?php echo $arr_item['login']; ?>" disabled>
    </div>
    <div class="form-group">
        <label for="Select">Статус задания</label>
        <select class="form-control" name="status" id="Select">
            <?php if ($arr_item['status'] === 0) : ?>
                <option><p style="color:red"><?php echo 'Не выполнено'; ?></p></option>
                <option><p style="color:green"><?php echo 'Выполнено'; ?></p></option>
            <?php elseif ($arr_item['status'] === 1) : ?>
                <option><p style="color:green"><?php echo 'Выполнено'; ?></p></option>
                <option><p style="color:red"><?php echo 'Не выполнено'; ?></p></option>
            <?php endif; ?>

        </select>
    </div>
    <div class="form-group">
        <label for="Body">Текст задачи</label>
        <textarea class="form-control" name="body" id="Body"
                  rows="10"><?php echo $arr_item['body']; ?></textarea>
    </div>
    <label for="id"></label>
    <input class="form-control" name="task_id" id="id" hidden="hidden"
           value="<?php echo $arr_item['task_id']; ?>">
    <div class="form-actions text-center">
        <input type="submit" value="Обновить" id="register-submit-btn" class="btn btn-success">
    </div>
    </form>

<?php endforeach; ?>