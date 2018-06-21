<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>My MVC Project</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="/starter-template.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <span class="navbar-brand">Мое приложение</span>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/" title="Default page(main/index) /без модели и вида/">Default page</a></li>
                <li><a href="/main/test" title="Тестовая(main/test) /без модели/">Тестовая</a></li>
                <li class="dropdown">
                    <a href="/profile" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Профиль <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/profile" title="Профиль(profile/index) /исп. модели/ /НЕОБХОДИМО БЫТЬ ЗАЛОГИНЕНЫМ/">Профиль</a></li>
                        <li><a href="/profile/edit" title="Профиль(profile/edit) /исп. модели/ /НЕОБХОДИМО БЫТЬ ЗАЛОГИНЕНЫМ/">Редактировать</a></li>
                        <li><a href="/profile/addfile" title="Профиль(profile/addfile) /исп. модели/ /НЕОБХОДИМО БЫТЬ ЗАЛОГИНЕНЫМ/">Добавить файлы</a></li>
                    </ul>
                </li>
                <li><a href="/login" title="Форма входа(login/index) /исп. модели/">Авторизация</a></li>
                <li><a href="/login/register" title="Форма регистрации(login/register) /исп. модели/">Регистрация</a></li>
                <li><a href="/information" title="Вывод всех пользователей (information/index/asc) /исп. модели/">Пользователи ASC</a></li>
                <li><a href="/information/index/desc" title="Все пользователи (information/index/desc) /исп. модели/">Пользователи DESC</a></li>

            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

    <?php
    require_once $content;
    ?>

</div><!-- /.container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="/js/main.js"></script>
<script src="/js/bootstrap.min.js"></script>

</body>
</html>