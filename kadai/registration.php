<?php
require_once dirname(__FILE__) .'/../data/require.php';
$user_id = $_POST['user_id'];
$password = $_POST['password'];
if(!$user_id && !$password){
    header("Location: insert.php");
    exit;
}
$conn = new DbConn();

$sql  = 'SELECT id,user_id,password FROM userslist';
$userslist= $conn->fetch($sql);

if($user_id && $password){
    $sql  = 'INSERT INTO';
    $sql .= '    userslist(user_id,password)';
    $sql .= '  VALUES ( ';
    $sql .= '   "'.$user_id.'","'.$password.'"';
    $sql .= '  )';
}
$login = 4;
if(preg_match("/^[a-zA-Z0-9]+$/", $user_id)){
    if (preg_match("/^[a-zA-Z0-9]+$/", $password)){
        $login = 3;
        if(preg_match("/^[a-zA-Z0-9]{6,8}+$/", $user_id)){
            if (preg_match("/^[a-zA-Z0-9]{6,8}+$/", $password)){
                $login = 1;
            }
        }
    }
}

foreach($userslist as $val){
    if($user_id == $val[user_id]){
        $login = 2;
    }
}

if($login == 1){
    $conn->fetch($sql);
}
//値の入った配列や変数の中身を表示
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
                    if($login == 1){
                        echo '<h3>登録が完了しました。</h3>';
                        echo '<form action="top.php" method="post">';
                        echo '    <input type="submit" value="食べたろTOPページへ" class="form-control" >';
                        echo '    <input type="hidden" name="user_id" value="'.$user_id.'">';
                        echo '    <input type="hidden" name="password" value="'.$password.'">';
                        echo '</form>';
                    }elseif($login == 2){
                        echo '<h3>同じIDのユーザがいます。他のIDで登録してください。</h3>';
                        echo '<form action="insert.php" method="post">';
                        echo '<input type="submit" value="登録ページに戻る" onclick="history.back()" class="form-control" >';
                        echo '    <input type="hidden" name="user_id" value="'.$user_id.'">';
                        echo '    <input type="hidden" name="password" value="'.$password.'">';
                        echo '</form>';
                    }elseif($login == 3){
                        echo '<h3>IDとパスワードの文字数は6〜8文字にしてください。</h3>';
                        echo '<form action="insert.php" method="post">';
                        echo '<input type="submit" value="登録ページに戻る" onclick="history.back()" class="form-control" >';
                        echo '    <input type="hidden" name="user_id" value="'.$user_id.'">';
                        echo '    <input type="hidden" name="password" value="'.$password.'">';
                        echo '</form>';
                    }elseif($login == 4){
                        echo '<h3>IDとパスワードは、半角英数字で入力してください。</h3>';
                        echo '<form action="insert.php" method="post">';
                        echo '<input type="submit" value="登録ページに戻る" onclick="history.back()" class="form-control" >';
                        echo '    <input type="hidden" name="user_id" value="'.$user_id.'">';
                        echo '    <input type="hidden" name="password" value="'.$password.'">';
                        echo '</form>';
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
