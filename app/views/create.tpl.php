<link rel="stylesheet" href="../../css/login_register.css">

<!--Валидация & Flash Message-->
<?php if(isset($pageData['error'])) :?>
    <p style="color:red"><?php echo $pageData['error']; ?></p>
<?php elseif (isset($pageData['task'])) : ?>
    <p style="color:green"><?php echo $pageData['task']; ?></p>
<?php endif; ?>

<!--ФОРМА TASK'a-->
<form action="" class="form-signin blank" method="post" novalidate="novalidate">
    <h1 class="h3 mb-3 font-weight-normal">Create task</h1>

    <div class="form-group inp-line">
        <input value="" name="login" id="inputLogin" class="form-control placeholder-no-fix marg" placeholder="Login"
               required>

        <input type="email" value="" name="email" id="inputEmail" class="form-control placeholder-no-fix"
               placeholder="Email address" required>
    </div>

    <div class="form-group">
        <textarea rows="10" cols="45" name="body" id="inputBody" class="form-control" placeholder="Write your task"
                  required></textarea>
    </div>

    <button class="btn btn-lg btn-primary btn-block" type="submit">
        Create task!
    </button>
</form>