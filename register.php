<?php
header("application/json");

try {
    session_start();
    $con = new PDO('mysql:host=127.0.0.1;dbname=tour;charset=utf8', 'root', '');
    $con->exec("set character set 'utf8'");
    $con->exec("set names 'utf8'");
} catch (PDOException $e) {
        echo json_encode(['status' => 1, 'text' => '数据库存入失败：' . $e->getMessage()]);
}

if (isset($_POST["register"])) {
    /*if (isset($_SESSION['id']))
    {
        echo json_encode(['status' => 1, 'text' => '您已成功注册过！']);
        exit;
    }*/

    // Judging the availability of the posted data.
    if (!isset($_POST['num']) || intval($_POST['num']) < 1)
    {
        echo json_encode(['status' => 1, 'text' => '人数输入错误，至少需1人报名。']);
        exit;
    }
    if (!isset($_POST['name']) || strlen($_POST['name']) > 20 || strlen($_POST['name']) == 0)
    {
        echo json_encode(['status' => 1, 'text' => '联系人姓名输入错误，可能是长度过长或未输入。']);
        exit;
    }

    if (!isset($_POST['route']) || !($_POST['route'] == '1' || $_POST['route'] == '2'))
    {
        echo json_encode(['status' => 1, 'text' => '请输入正确的路线编号，1或2。']);
        exit;
    }
    if (!isset($_POST['phone']) || strlen($_POST['phone']) != 11)
    {
        echo json_encode(['status' => 1, 'text' => '移动电话号码输入错误，请输入正确的11位数字联系电话。']);
        exit;
    }
    if (!isset($_POST['email']) || strlen($_POST['email']) > 30 || strlen($_POST['email']) <= 2)
    {
        echo json_encode(['status' => 1, 'text' => '电子邮箱地址输入错误，可能是长度过长或未输入。']);
        exit;
    }

    // Saving the data to MySql.
    try {
        $query = $con->prepare("INSERT INTO reg (num, name, route, phone, email) VALUES (?,?,?,?,?)");
        $query->execute([intval($_POST['num']), $_POST['name'], $_POST['route'], $_POST['phone'], $_POST['email']]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 1, 'text' => '数据库存入失败：' . $e->getMessage()]);
        exit;
    }
    echo json_encode(['status' => 0, 'text' => '注册成功！']);
    $_SESSION['id'] = $con->lastInsertId();
}

if (isset($_POST["feedback"])) {
    try {
        $query = $con->prepare("INSERT INTO fdbk (postscript) VALUES (?)");
        $query->execute([$_POST['postscript']]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 1, 'text' => '数据库存入失败：' . $e->getMessage()]);
        exit;
    }
}
?>
