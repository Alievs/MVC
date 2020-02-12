<?php if(isset($pageData['error'])) :?>
    <p style="color:red"><?php echo $pageData['error']; ?></p>
<?php elseif (isset($pageData['error2'])) : ?>
    <p style="color:red"><?php echo $pageData['error2']; ?></p>
<?php endif; ?>

<div class="container table-block">
    <div class="row table-cell-block">
        <form action="" class="form-signin" method="post" novalidate="novalidate">

            <h1>Авторизоваться</h1>
            <label for="inputLogin" class="sr-only">Email address</label>
            <input value="" name="login" id="inputLogin" class="form-control" placeholder="Login" min="4" required
                   autofocus>

            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>


            <button class="btn btn-lg btn-primary btn-block" type="submit">
                Войти
            </button>
        </form>
    </div>
</div>
