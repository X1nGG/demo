<?php

if (!checkAuthorization()) {
    error403();
}

$errors['form']['fields']['title'] = [];
$errors['form']['fields']['description'] = [];
$errors['form']['fields']['parent_id'] = [];
$values['form']['title'] = '';
$values['form']['description'] = '';
$values['form']['parent_id'] = 0;
$values['form']['success'] = false;

if (!empty($_POST['save'])) {

    $values['form']['title'] = $_POST['title'];
    $values['form']['description'] = $_POST['description'];
    $values['form']['parent_id'] = $_POST['parent_id'];

    //validation
    if (!is_string($_POST['title']) || mb_strlen($_POST['title']) > 250) {
        $errors['form']['fields']['title'][] = 'Слишком длинное название объекта';
    }
    if (!is_string($_POST['description'])) {
        $errors['form']['fields']['description'][] = 'Ошибка значения';
    }
    if (!is_numeric($_POST['parent_id'])) {
        $errors['form']['fields']['parent_id'][] = 'Ошибка значения';
    }

    if ((int)$_POST['parent_id'] !== 0) {
        $dbq = $db->prepare('SELECT * FROM objects WHERE id = :parent_id LIMIT 1');
        $dbq->bindValue(':parent_id', (int)$_POST['parent_id']);
        $dbq->execute();
        $checkObject = $dbq->fetch();
        if (empty($checkObject)) {
            $errors['form']['fields']['parent_id'][] = 'Родительского объекта с таким id не существует, укажите в поле значение 0 если требуется добавить корневой элемент';
        }
    }

    if (empty($errors['form']['fields']['title']) && empty($errors['form']['fields']['description']) && empty($errors['form']['fields']['parent_id'])) {
        $dbq = $db->prepare('INSERT INTO objects SET title = :title, description = :description, parent_id = :parent_id');
        $dbq->bindValue(':title', $_POST['title']);
        $dbq->bindValue(':description', $_POST['description']);
        $dbq->bindValue(':parent_id', (int)$_POST['parent_id']);
        if ($dbq->execute()) {
            if (!empty((int)$_POST['parent_id'])) {
                updateChildsStatus((int)$_POST['parent_id'], $db);
            }
            $values['form']['success'] = true;
        }
    }
}

$dbq = $db->prepare('SELECT * FROM objects');
$dbq->execute();
$objectsList = $dbq->fetchAll();

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
                    <a title="Назад" class="btn" href="./admin">&lt;&lt; назад</a>
                </div>
                <div class="container">
                    <form method="POST">
                        <table class="edit-table">
                            <tr>
                                <th colspan="2">Добавление объекта</th>
                            </tr>
                            <tr>
                                <td colspan="2"><br></td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="title"><b>Название объекта</b></label></td>
                                <td>
                                    <input id="title" class="<?= empty($errors['form']['fields']['title']) ? '' : 'error' ?>" type="text" placeholder="" name="title" required value="<?= @$values['form']['title'] ?>">
                                    <?php foreach ($errors['form']['fields']['title'] as $message) { ?>
                                        <div class="message error"><?php echo $message; ?></div>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="description"><b>Описание объекта</b></label></td>
                                <td>
                                    <textarea id="description" name="description" class="<?= empty($errors['form']['fields']['description']) ? '' : 'error' ?>" required><?= @$values['form']['description'] ?></textarea>
                                    <?php foreach ($errors['form']['fields']['description'] as $message) { ?>
                                        <div class="message error"><?php echo $message; ?></div>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="parentId"><b>id родительского объекта</b></label></td>
                                <td>
                                    <select id="parentId" name="parent_id" class="<?= empty($errors['form']['fields']['parent_id']) ? '' : 'error' ?>">
                                        <option value="0">Нет</option>
                                        <?php foreach ($objectsList as $objectItem) { ?>
                                            <option value="<?=$objectItem['id']?>"><?=$objectItem['title']?></option>
                                        <?php } ?>
                                    </select>
                                    <?php foreach ($errors['form']['fields']['parent_id'] as $message) { ?>
                                        <div class="message error"><?php echo $message; ?></div>
                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <button title="Сохранить" class="save" name="save" type="submit" value="1">Сохранить</button>
                        <br>
                        <?php if ($values['form']['success']) { ?>
                            <div class="message">Сохранено</div>
                        <?php } ?>
                    </form>
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