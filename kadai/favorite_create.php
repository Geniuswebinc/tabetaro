<?php
require_once dirname(__FILE__) .'/data/require.php';
$user_id = $_POST['user_id'];
$password = $_POST['password'];
$delete = $_POST['delete'];
$favorite_id = $_POST['favorite_id'];
$id = $_POST['id'];
if(!$user_id && !$password){
    header("Location: index.php");
    exit;
}
$conn = new DbConn();

$sql  = 'SELECT userslist_id,user_id,password FROM userslist';
$userslist= $conn->fetch($sql);

foreach($userslist as $val){
    if($user_id == $val[user_id]){
        $userslist_id = $val[userslist_id];
    }
}
// var_dump($user_id);
// var_dump($sql);
$sql  = 'SELECT id,foods_name,hiragana,favorite_id,foods_id,whose_id,userslist_id FROM food_lists';
$sql .= '   LEFT OUTER JOIN favorite';
$sql .= '   ON food_lists.id = favorite.foods_id';
$sql .= '   LEFT OUTER JOIN userslist';
$sql .= '   ON userslist.userslist_id = favorite.whose_id';
$favorite_food_userslist= $conn->fetch($sql);
var_dump($sql);


foreach($favorite_food_userslist as $val){
    if($id == $val[id]){
        $foods_name = $val[foods_name];
    }
}

// var_dump($sql);
if($foods_name){
    $sql  = 'INSERT INTO';
    $sql .= '    favorite (whose_id,foods_id,favorite_words)';
    $sql .= '  VALUES ( ';
    $sql .= '   '.$userslist_id.','.$id.',"'.$foods_name.'"';
    $sql .= '  )';
    $conn->fetch($sql);
}
if($delete){
    $sql  = 'DELETE FROM favorite';
    $sql .= '   WHERE favorite_id = '.$favorite_id.'';
    $conn->execute($sql);
}
// $sql  = 'SELECT id,foods_name,hiragana FROM food_lists';
// $sql .= '   ORDER BY hiragana';
// $food_lists= $conn->fetch($sql);
$sql  = 'SELECT favorite_id,foods_id,favorite_words FROM favorite';
$sql .= '   WHERE whose_id = '.$userslist_id.'';
$favorite_table= $conn->fetch($sql);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>食べたろ お気に入り登録</title>
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
            <div class="col-xs-3">
                <img src="./img/maru.png" width="50" height="50" alt="食べたろ">
            </div>
            <div class="col-xs-9">
                <div class="text-right">
                    <form action="top.php" method="post">
                        <input type="image" src="./img/pagetop.png" alt="トップに戻る"class="pagetop">
                        <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                        <input type="hidden" name="password" value="<?php echo $password;?>">
                    </form>
                </div>
            </div>
        </div>
        <form action="favorite_create.php" method="post">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <select class="form-control" name="id">
                            <?php
                            // foreach($food_lists as $val){
                            //     echo '<option value="'.$val['id'].'">'.$val['foods_name'].'</option>';
                            // }
                            foreach($favorite_food_userslist as $val){
                                echo '<option value="'.$val['id'].'">'.$val['foods_name'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <input type="submit" value="お気に入りに登録" class="form-control">
                        <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                        <input type="hidden" name="password" value="<?php echo $password;?>">
                    </div>
                </div>
            </div>
        </form>
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
                            echo '    <td>'.$val['favorite_words'].'</td>';
                            echo '    <td>';
                            ?>
                            <form action="favorite_create.php" method="post">
                                <input type="submit" value="削除">
                                <input type="hidden" name="delete" value="1">
                                <input type="hidden" name="favorite_id" value="<?php echo $val['favorite_id']; ?>" class="btn btn-default">
                                <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                                <input type="hidden" name="password" value="<?php echo $password;?>">
                            </form>
                            <?php
                            echo '    </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- この下に取得したデータを表示します。 -->
    </div>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type='text/javascript' src="./assets/js/app.js"></script>
</body>
</html>
