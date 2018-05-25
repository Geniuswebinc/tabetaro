<?php
require_once dirname(__FILE__) .'/../data/require.php';
//変数の受け取り
$user_id = $_POST['user_id'];
$password = $_POST['password'];
$food = $_POST['food'];
$range = $_POST['range'];
$date = $_POST['date'];
$delete = $_POST['delete'];
$favorite_id = $_POST['favorite_id'];
$foods_id = $_POST['foods_id'];
//別ページから移動してきた時に、ログインされていなかった場合はログインページへ移動します。
if(!$user_id && !$password){
    header("Location: index.php");
    exit;
}
$conn = new DbConn();
//DBからユーザ情報を取得

$search=array(
    'shops_name1'  => 'こんにちは、まごころ創作ダイニングＭＡＫＯＴＯです',
    'shops_name2' => 'こんばんは、まごころ創作ダイニングですよ',
    'shops_name3' => 'おはようＭＡＫＯＴＯです。',
);





$sql  = 'SELECT shops_name FROM shop_lists';
$shop_lists= $conn->fetch($sql);

var_dump($search);
var_dump($sql);

$sql  = 'SELECT userslist_id,user_id,password FROM userslist';
$userslist= $conn->fetch($sql);

//取得したユーザ情報とログイン時に取得したIDとパスワードを照合し、該当するもののid（DBのid）を取得する。
foreach($userslist as $val){
    if($user_id == $val[user_id]){
        $userslist_id = $val[userslist_id];
    }
}

if($delete){
    $sql  = 'DELETE FROM favorite';
    $sql .= '   WHERE favorite_id = '.$favorite_id.'';
    $conn->execute($sql);
}
$sql  = 'SELECT userslist_id,user_id,password FROM userslist';
$userslist= $conn->fetch($sql);

$sql  = 'SELECT id,foods_name,hiragana FROM food_lists';
$sql .= '   ORDER BY hiragana';
$food_lists= $conn->fetch($sql);

$sql  = 'SELECT favorite_id,foods_id,favorite_words FROM favorite';
$sql .= '   WHERE whose_id = '.$userslist_id.'';
$favorite_table= $conn->fetch($sql);
//値の入った配列や変数の中身を表示
// var_dump($favorite_table);
// var_dump($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>食べたろ</title>
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
            <div class="col-xs-6">
                <div class="text-left">
                    <img src="./img/maru.png" alt="食べたろ" class="title">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="text-right">
                    <form action="top.php" method="post">
                        <input type="image" src="./img/button-update.png" alt="更新" class="update">
                        <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                        <input type="hidden" name="password" value="<?php echo $password;?>">
                    </form>
                </div>
            </div>
            <div class="col-xs-3">
                <input type="image" src="./img/menu_button.png" alt="メニュー" id="menu" class="menu">
            </div>
        </div>
        <div id="hihyouzi">
            <form action="top.php" method="post">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <select class="form-control" name="food">
                                <?php
                                foreach($food_lists as $val){
                                    echo '<option ';if($foods_id==$val['id']){echo selected;}echo '>'.$val['foods_name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <select name="range"class="form-control">
                                <option value="0.5">徒歩5分</option>
                                <option value="1" selected>徒歩10分</option>
                                <option value="1.5">徒歩15分</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <select name="date" class="form-control">
                                <option value="50">50件</option>
                                <option value="75" selected>75件</option>
                                <option value="100">100件</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <input type="submit" value="検索" class="form-control">
                            <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                            <input type="hidden" name="password" value="<?php echo $password;?>">
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <?php
                        // for($i = 0; $i < $date; $i++){
                        //     echo '<p>テスト</p>';
                        //     foreach($shop_lists as $value1){
                        //         foreach($search as $value2){
                        //             if(strpos($value1[shops_name],$value2[shops_name] === true)){
                        //                 echo '<form action="http://maps.google.com/maps?q='.$search.'" method="post">';
                        //                     echo '    <input type="submit" value="お店の場所を検索">';
                        //                     echo '</form>';
                        //                 }
                        //             }
                        //         }
                        //     }
                            if(strpos($shop_lists[shops_name],$search[shops_name] === false)){
                                echo '<form action="http://maps.google.com/maps?q='.$search.'" method="post">';
                                echo '    <input type="submit" value="お店の場所を検索">';
                                echo '</form>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- この下に取得したデータを表示します。 -->
            <div id="hyouzi">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="text-center">
                            <p class="okiniiri">＃お気に入り</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table">
                            <thead></thead>
                            <tbody>
                                <?php
                                foreach($favorite_table as $val){
                                    echo '<tr>';
                                    echo '    <form action="top.php" method="post">';
                                    echo '        <td>';
                                    echo '            <input type="submit" value="'.$val['favorite_words'].'">';
                                    ?>
                                    <input type="hidden" name="foods_id" value="<?php echo $val['foods_id']; ?>">
                                    <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                                    <input type="hidden" name="password" value="<?php echo $password;?>">
                                    <?php
                                    echo '        </td>';
                                    echo '    </form>';
                                    echo '    <form action="top.php" method="post">';
                                    echo '        <td>';
                                    ?>
                                    <input type="submit" value="削除">
                                    <input type="hidden" name="delete" value="1">
                                    <input type="hidden" name="favorite_id" value="<?php echo $val['favorite_id']; ?>" class="btn btn-default">
                                    <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                                    <input type="hidden" name="password" value="<?php echo $password;?>">
                                    <?php
                                    echo '        </td>';
                                    echo '    </form>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="text-center">
                            <form action="favorite_create.php" method="post">
                                <input type="image" src="./img/button-update.png" alt="お気に入りページへ" class="update">
                                <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                                <input type="hidden" name="password" value="<?php echo $password;?>">
                            </form>
                        </div>
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
