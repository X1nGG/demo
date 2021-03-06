<?php
//////////////////////////////////
// Параметры доступа к БД mysql //
//////////////////////////////////

$dbserver   = "127.0.0.1";      // адрес сервера mysql
$dbname     = "test";           // название базы данных
$dbuser     = "test";           // имя пользователя mysql
$dbpassword = "test";           // пароль пользователя mysql
$dbcharset  = "utf8mb4";        // кодировка БД по умолчанию

//////////////////////////////////
//////// Общие настройки /////////
//////////////////////////////////
$appName = '他看了使用说明 DEMO 他看了使用说明'; // Название приложения
$appTitle = 'DEMO';                            // Заголовок приложения

//Пользователи
$serviceUsers = [];
$serviceUsers['admin']['id'] = 1;                 //id
$serviceUsers['admin']['login'] = 'admin';        //Логин
$serviceUsers['admin']['name'] = 'Администратор'; //Имя
$serviceUsers['admin']['m_name'] = '';            //Отчество
$serviceUsers['admin']['l_name'] = '';            //Фамилия
$serviceUsers['admin']['password'] = '12345678';  //Пароль

//Страницы
$pagesList = [
    '/' => './pages/index.php',
    '/admin' => './pages/admin.php',
    '/add' => './pages/add.php',
    '/edit' => './pages/edit.php',
    '/delete' => './pages/delete.php',

    '/404' => './pages/service/404.php',
    '/403' => './pages/service/403.php',

    '/api/get-data' => './api/api.php'
];