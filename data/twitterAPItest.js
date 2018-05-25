
protected function get_bearer_token(){
// 設定項目
$api_key = '4Yg01M8U7iauQOedsqtlSR5QU'; // ApplicationManagementから確認したAPIキーをセットしてください
$api_secret = 'Lu2yUUQR0zr17EKSNvYNLAxWRTi5oIgShvguSaIqxUY38'; //ApplicationManagementから確認したAPIシークレットをセットしてください

// クレデンシャルを作成
$credential = base64_encode( $api_key . ':' . $api_secret );
// リクエストURL
$request_url = 'https://api.twitter.com/oauth2/token';
// リクエスト用のコンテキストを作成する
'Authorization: Basic ' . $credential,
$context = array(
    'http' => array(
        'method' => 'POST', // リクエストメソッド
        'header' => array(            // ヘッダー
            'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
        ) ,
        'content' => http_build_query(  // ボディ
            array(
                'grant_type' => 'client_credentials',
            )
        ),
    ),
);

// cURLを使ってリクエスト
$curl = curl_init() ;
curl_setopt( $curl , CURLOPT_URL , $request_url );
curl_setopt( $curl , CURLOPT_HEADER, 1 );
curl_setopt( $curl , CURLOPT_CUSTOMREQUEST , $context['http']['method'] );  // メソッド
curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false );                      // 証明書の検証を行わない
curl_setopt( $curl , CURLOPT_RETURNTRANSFER , true );                       // curl_execの結果を文字列で返す
curl_setopt( $curl , CURLOPT_HTTPHEADER , $context['http']['header'] );     // ヘッダー
curl_setopt( $curl , CURLOPT_POSTFIELDS , $context['http']['content'] );    // リクエストボディ
curl_setopt( $curl , CURLOPT_TIMEOUT , 10 );                                // タイムアウトの秒数

$res1 = curl_exec( $curl );
$res2 = curl_getinfo( $curl );
curl_close( $curl );

// 取得したデータ

$json = substr( $res1, $res2['header_size'] );       // 取得したデータ(JSONなど)

$header = substr( $res1, 0, $res2['header_size'] );  // レスポンスヘッダー (検証に利用したい場合にどうぞ)

// JSONをオブジェクトに変換
$obj = json_decode( $json);

// エラー判定

if( !$obj || !isset( $obj->access_token ) )
{
    return FALSE;
    }else
{
    $bearer_token = $obj->access_token;
    return $bearer_token;
    }
}
public function get_by_hashtag(){
    // ベアラートークンを取得

    $bearer_token = $this->get_bearer_token();

    if(empty($bearer_token)){
        echo "ERROR: ベアラートークンが取得できませんでした";
        exit;
    }

    $request_url = 'https://api.twitter.com/1.1/search/tweets.json';       // エンドポイント

    // パラメータ

    $params = array(

        'q' => 'ミヤチク filter:images',       // 検索キーワード (必須)
        //      'count' => '20',         // 取得件数
        //      'until' => '2016-03-21', // 最新日時
        //      'since_id' => '11111',   // 最古のツイートID
        //      'max_id' => '99999',     // 最新のツイートID
        //      'include_entities' => 'true',  // ツイートオブジェクトのエンティティを含める
    ) ;

    // パラメータがある場合
    if( $params )
    {
        $request_url .= '?' . http_build_query( $params );
    }
    // リクエスト用のコンテキスト
    $context = array(
        'http' => array(
            'method' => 'GET' , // リクエストメソッド
            'header' => array(            // ヘッダー
                'Authorization: Bearer ' . $bearer_token ,
            ) ,
        ) ,
    ) ;

    // cURLを使ってリクエスト

    $curl = curl_init();

    curl_setopt( $curl , CURLOPT_URL , $request_url );
    curl_setopt( $curl , CURLOPT_HEADER, 1 );
    curl_setopt( $curl , CURLOPT_CUSTOMREQUEST , $context['http']['method'] ); // メソッド
    curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false );                     // 証明書の検証を行わない
    curl_setopt( $curl , CURLOPT_RETURNTRANSFER , true );                      // curl_execの結果を文字列で返す
    curl_setopt( $curl , CURLOPT_HTTPHEADER , $context['http']['header'] );    // ヘッダー
    curl_setopt( $curl , CURLOPT_TIMEOUT , 10 );                               // タイムアウトの秒数
    $res1 = curl_exec( $curl );
    $res2 = curl_getinfo( $curl );
    curl_close( $curl );

    // 取得したデータ
    $json = substr( $res1, $res2['header_size'] ) ;             // 取得したデータ(JSONなど)
    $header = substr( $res1, 0, $res2['header_size'] ) ;        // レスポンスヘッダー (検証に利用したい場合にどうぞ)

    // JSONをオブジェクトに変換
    $obj = json_decode( $json ) ;
    // エラー判定
    if( !$json || !$obj )
    {
        echo "ERROR: データが取得できませんでした";
        exit;
    }
    echo $json;
    exit;
}
