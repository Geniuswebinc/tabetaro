<?php
require_once dirname(__FILE__) .'/../data/require.php';
$conn = new DbConn();

//変数の受け取り
$user_id = $_POST['user_id'];
$password = $_POST['password'];
$food = $_POST['food'];
$range = $_POST['range'];
$date = $_POST['date'];
$delete = $_POST['delete'];
$favorite_id = $_POST['favorite_id'];
$foods_id = $_POST['foods_id'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$obj = $_POST['obj'];
//別ページから移動してきた時に、ログインされていなかった場合はログインページへ移動します。
if(!$user_id && !$password){
    header("Location: index.php");
    exit;
}
require_once dirname(__FILE__) .'/../data/accessToken.php';

//値を分ける
$x = $latitude;
$y = $longitude;
$x1 = $x + 0.01;
$x2 = $x - 0.01;
$y1 = $y + 0.01;
$y2 = $y - 0.01;

$sql  = 'SELECT id,shops_name,x,y FROM shop_lists ';
$sql .= ' WHERE ('.$x1.' >= x AND x >= '.$x2.') ';
$sql .= ' AND ('.$y1.' >= y AND y >= '.$y2.') ';
$coordinate = $conn->fetch($sql);

$sql  = 'SELECT id,shops_name,address FROM shop_lists';
$shop_lists= $conn->fetch($sql);

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
if($food && $range && $date){
    $count = 0;
    foreach($obj->statuses as $key => $val){
            $tweetCheck = $val->text;
        $count++;//ツイートの回数を確認

        foreach($coordinate as $val2){
            if(strpos($tweetCheck,$val2[shops_name]) !== false){
                $tweet_shops_name = array(
                    $count => array(
                        'shops_name' => $val2[shops_name],
                    ),
                );
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcH_SOkQ7qaFjZNuXIqEhMPc5CLvGk9N4&language=ja&libraries=drawing,geometry,places,visualization" async defer></script>

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

            <div class="col-xs-6">
                <div class="text-right">
                    <input type="image" src="./img/menu_button.png" alt="メニュー" id="menu" class="menu">
                </div>
            </div>
        </div>
        <div id="hihyouzi">
            <form action="top.php" method="post" id="form1">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <select class="form-control input-lg" name="food">
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
                            <select name="range" class="form-control input-lg">
                                <option value="0.5km">徒歩5分</option>
                                <option value="1km">徒歩10分</option>
                                <option value="1.5km" selected>徒歩15分</option>
                                <option value="2km">徒歩20分</option>
                                <option value="2.5km">徒歩25分</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <select name="date" class="form-control input-lg">
                                <option value="50">50件</option>
                                <option value="75">75件</option>
                                <option value="100" selected>100件</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <input type="button" value="検索" id="getLocation" class="form-control input-lg">
                            <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                            <input type="hidden" name="password" value="<?php echo $password;?>">
                            <input type="hidden" name="latitude" id="latitude" value="">
                            <input type="hidden" name="longitude" id="longitude" value="">
                        </div>
                    </div>
                </div>
            </form>
            <?php
            if($food && $range && $date){
                //googlemapのURLs
                foreach($obj->statuses as $key => $val){
                    //投稿時間を変換
                    $data_str = date('Y年m月d日 h:i:s', strtotime($val->created_at));
                    //本文取得,p　JSON形式をテキスト形式に変換
                    $tweetCheck = $val->text;
                    $tweet = preg_replace("/https.+$/","",$tweetCheck);

                    $good_cnt = $val->favorite_count;
                    ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="tweet">
                                <?php
                                echo '<p class="tweet_font-weight"><br>投稿日時：</p>';
                                echo "<p>{$data_str}<br></p>";
                                echo '<p class="tweet_font-weight">ツイート文：<br></p>';
                                echo "<p>{$tweet}<br></p>";
                                echo '<p class="tweet_font-weight">いいねの数：</p>';
                                echo "<p>{$good_cnt}回<br></p>";
                                ?>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <?php
                            //ツイートに添付されている画像を全て表示　APIの仕様上一枚しか取れない可能性あり
                            $medias = $val->entities->media;
                            foreach($medias as $key3 => $media){
                                echo "<img width='100%' src='{$media->media_url}'><br>";
                            }
                            //ハッシュタグの取得　中身全てを取るパターン 成功
                            // $tags=$val->entities->hashtags;
                            // foreach ($tags as $key2 => $tag) {
                            //     echo "#" . $tag->text . "<br>";
                            // }
                            //いいねの数を取得
                            ?>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                            <?php
                            $count2++;
                            if($tweet_shops_name[$count2] == true){
                                ?>
                                <input type="button" value="お店の場所を検索" onClick="window.open('http://maps.google.com/maps?q=<?php echo $tweet_shops_name[$count2]['shops_name'];?>')" class="form-control input-lg">
                                <?php
                            }
                            ?>
                        </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <!-- この下に取得したデータを表示します。 -->
        <div id="hyouzi">
            <div class="row">
                <div class="col-xs-12">
                    <div class="text-center">
                        <p class="favorite_title">＃お気に入り</p>
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
                                echo '        <td>';
                                echo '    <form action="top.php" method="post">';
                                echo '            <input type="submit" value="'.$val['favorite_words'].'" class="form-control input-lg">';
                                ?>
                                <input type="hidden" name="foods_id" value="<?php echo $val['foods_id']; ?>" class="form-control input-lg">
                                <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                                <input type="hidden" name="password" value="<?php echo $password;?>">
                                <?php
                                echo '    </form>';
                                echo '        </td>';
                                echo '        <td>';
                                echo '    <form action="top.php" method="post">';
                                ?>
                                <input type="submit" value="削除" class="form-control input-lg">
                                <input type="hidden" name="delete" value="1">
                                <input type="hidden" name="favorite_id" value="<?php echo $val['favorite_id']; ?>" class="btn btn-default">
                                <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                                <input type="hidden" name="password" value="<?php echo $password;?>">
                                <?php
                                echo '    </form>';
                                echo '        </td>';
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
    <!-- <div class="col-xs-3">
    <div class="text-right">
    <form action="top.php" method="post">
    <input type="image" src="./img/button-update.png" alt="更新" class="update">
    <input type="hidden" name="user_id" value="<?php //echo $user_id;?>">
    <input type="hidden" name="password" value="<?php //echo $password;?>">
</form>
</div>
</div> -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type='text/javascript' src="./assets/js/app.js"></script>
</body>
</html>
