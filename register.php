<?php
/**
 * Created by PhpStorm.
 * User: 天一standard
 * Date: 2015/10/24
 * Time: 21:53
 */
try {
    session_start();
    $con = new PDO('mysql:host=127.0.0.1;dbname=tour;charset=utf8', 'root', '');
    //if (!$con) {
    //   echo "could not connect to mysql!";
    //  exit;
    //}
    $con->exec("set character set 'utf8'");//读库
    $con->exec("set names 'utf8'");//写库
} catch (PDOException $e) {
    print "Error: ". $e->getMessage(). "</br>";
}

if (isset($_POST["submit"]))
{
    print "<script>alert(\"1\");</script>>";
    try
    {
        $query = $con->prepare("INSERT INTO reg (name, phone, email) VALUES (?,?,?)");
        $query->execute(array($_POST['name'], $_POST['phone'], $_POST['email']));
        $_SESSION['id']=$con->lastInsertId();
    }
    catch (PDOException $e){
        print "Error: ". $e->getMessage(). "</br>";
        die();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>少年班学院接待团参观报名</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<h1>少年班学院接待团参观报名</h1>
    <div class="container">
        <div class="row">
            <form role="form" method="post">
                <div class="form-group">
        <label for="name">姓名</label>
        <input type="text" class="form-control" placeholder="姓名" name="name" id="name"/>
                    </div>
                <div class="form-group">
            <label for="phone">电话</label>
        <input type="text" class="form-control" placeholder="电话" name="phone" id="phone"/>
                    </div>
                <div class="form-group">
                    <label for="email">电子邮箱</label>
                    <input type="text" class="form-control" placeholder="电子邮箱" name="email" id="email"/>
                <button type="submit" class="btn btn-success" name="submit" value="submit">立即报名!</button>
                </form>
        </div>
    </div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>