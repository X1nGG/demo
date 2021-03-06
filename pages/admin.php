<?php

if (!checkAuthorization()) {
    error403();
}

$dbq = $db->prepare('SELECT * FROM objects');
$dbq->execute();
$objects = $dbq->fetchAll();

?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <title><?=$appTitle?></title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="/public/main.css">
        <script src="/public/main.js"></script>
    </head>
    <body>
        <div>
            <header>
                <div class="box">
                    <?php if (!empty($_SESSION['auth'])) { ?>
                        <form method="POST">
                            <button class="logout" title="Разлогиниться" id="unauthorize" name="unauthorize" type="submit" value="1"><img alt="logout" src="./public/logout.png"></button>
                        </form>
                    <?php } ?>
                    <div>
                        <h1><?= $appName ?></h1>
                    </div>
                </div>
            </header>
            <div id="technologies">
                <span id="t1">PHP8</span>
                <span id="t2">JS</span>
                <span id="t3">MySQL</span>
                <span id="t4">GIT</span>
                <span id="t5">GIMP</span>
            </div>
            <div class="main">
                <div class="container">
                    <a title="На главную страницу" class="btn" href="./">&lt;&lt; На главную</a>
                    <br>
                </div>
                <br>
                <div class="container">
                    <h2>Структура данных:</h2>
                    <br>
                    <a title="Добавить объект в дерево" class="btn btn-green btn-border" href="./add">Добавить</a>
                    <br>
                    <br>
                    <table class="list-table">
                        <tr>
                            <th>id</th>
                            <th>Название</th>
                            <th>Родительский объект</th>
                            <th></th>
                        </tr>
                        <?php foreach ($objects as $item) { ?>
                            <tr>
                                <td>
                                    <?=$item['id']?>
                                </td>
                                <td>
                                    <a href="./edit?id=<?=$item['id']?>"><?=$item['title']?></a>
                                </td>
                                <td>
                                    <?php if (empty($item['parent_id'])) { ?>
                                        -
                                    <?php } else { ?>
                                        ID <?=$item['parent_id']?>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a title="Удалить объект" href="./delete?id=<?=$item['id']?>" class="btn">удалить</a>
                                    <a class="btn" href="./edit?id=<?=$item['id']?>">редактировать</a>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="4"><br></td>
                        </tr>
                    </table>
                </div>
            </div>
            <footer>
                <div>
                    <img alt="demo" src="/public/demo-guy.png" />
                    <br>
                    <span>© Kartoshkin "DEMO"</span>
                </div>
                <?php foreach ($errors['system'] as $error) { ?>
                    <div class="message error"><?php echo $error; ?></div>
                <?php } ?>
                <?php foreach ($messages['sysinfo'] as $message) { ?>
                    <div class="message"><?php echo $message; ?></div>
                <?php } ?>
            </footer>
        </div>
    </body>
</html>