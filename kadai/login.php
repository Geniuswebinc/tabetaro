<?php
require_once dirname(__FILE__) .'/../data/require.php';
$user_id = $_POST['user_id'];
$password = $_POST['password'];
if(!$user_id && !$password){
    header("Location: index.php");
    exit;
}
$conn = new DbConn();

$sql  = 'SELECT user_id,password FROM userslist';
$userslist= $conn->fetch($sql);
//IDとパスワードを照合
foreach($userslist as $val){
    if($user_id == $val[user_id]){
        if($password == $val[password]){
            $login = TRUE;
        }
    }
}
//値の入った配列や変数の中身を表示
// var_dump($favorite_table);

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
                <div class="form-group">
                    <?php
                    if($login){
                        echo '<h3>ログインが完了しました。</h3>';
                        echo '<form action="top.php" method="post">';
                        echo '    <input type="submit" value="食べたろTOPページへ" class="form-control input-lg" >';
                        echo '    <input type="hidden" name="user_id" value="'.$user_id.'">';
                        echo '    <input type="hidden" name="password" value="'.$password.'">';
                        echo '</form>';
                    }elseif(!$login){
                        echo '<h3>ログイン出来ませんでした。もう一度入力してください。</h3>';
                        echo '<input type="submit" value="ログインページに戻る" onclick="history.back()" class="form-control input-lg" >';
                        echo '    <input type="hidden" name="user_id" value="'.$user_id.'">';
                        echo '    <input type="hidden" name="password" value="'.$password.'">';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type='text/javascript' src="./assets/js/app.js"></script>
</body>
</html>
