<?php

return array
(
    array('label'=> 'Главная',                  'route'=> 'index',                  'pages'=> array(
        array('label'=> 'Регистрация',          'route'=> 'register', ),
        array('label'=> 'Вход',                 'route'=> 'login'),
    )),

    array('label'=> 'Регистрация',              'route'=> 'register'),
    array('label'=> 'Вход',                     'route'=> 'login'),
    array('label'=> 'Страницы',                 'route'=> 'pages-view'),

    array('label'=> 'Админка',                  'route'=> 'admin',                  'pages'=> array(

        array('label'=> 'Пользователи',         'route'=> 'admin-users-page',       'params'=>array('page'=>1),      'pages'=> array(
            array('label'=> 'Создать аккаунт',  'route'=> 'admin-users-create'),
            array('label'=> 'Изменить аккаунт', 'route'=> 'admin-users-update'),
            array('label'=> 'Информация',       'route'=> 'admin-users-view'),
        )),

        array('label'=> 'Билеты',               'route'=> 'admin-tickets-page',     'params'=>array('page'=>1),      'pages'=> array(
            array('label'=> 'Create ticket',    'route'=> 'admin-tickets-create'),
            array('label'=> 'Update ticket',    'route'=> 'admin-tickets-update'),
            array('label'=> 'View ticket',      'route'=> 'admin-tickets-view'),
        )),

        array('label'=> 'Хотелки',              'route'=> 'admin-wishes'),
    )),

);

