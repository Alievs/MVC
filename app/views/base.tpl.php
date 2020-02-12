<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/login_register.css">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand logoAn" href="/">Главная страница</a>

        <div class="collapse navbar-collapse" id="navbarResponsive">

            <ul class="navbar-nav ml-auto">

                <?php if (!empty($_SESSION['admin'])) : ?>
                    <li class="login"><a class="nav-button" href="/login/logout">Выйти</a></li>
                <?php  else : ?>
                    <li class="login"><a class="nav-button" href="/login">Войти</a></li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>


<?php include VIEW_PATH . $pageTpl; ?>



<div id="footer">

</div>
<!-- JavaScript -->
<script src="/js/jquery.js"></script>
