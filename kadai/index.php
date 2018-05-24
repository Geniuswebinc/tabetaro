<?php
require_once dirname(__FILE__) .'/data/require.php';
$conn = new DbConn();

// var_dump($date);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>食べたろ　ログインページ</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/app.css">
    <meta name="Content-Style-Type" content="text/css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>ログインページ</h1>
            </div>
        </div>
        <form action="login.php" method="post">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <input type="text" name="user_id" placeholder="IDを入力" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <input type="password" name="password" placeholder="パスワードを入力" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <input type="submit" value="ログイン" class="form-control">
                    </div>
                </div>
            </div>
        </form>
        <form action="insert.php" method="post">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <input type="submit" value="新規登録の方はこちら" class="form-control">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type='text/javascript' src="./assets/js/app.js"></script>
</body>
</html>
