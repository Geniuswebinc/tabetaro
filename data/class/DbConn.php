<?php

/**
 * MySQLの接続の為のクラス
 * Class for connecting MySQL
 *
 * @author gami
 */
class DbConn
{
    /**
     * コンストラクタ
     * @var host:ホスト
     * @var user:ユーザー
     * @var pass:パス
     * @var db:データーベース名
     */
    function __construct()
    {
        $this->host = DB_HOST;
        $this->user = DB_USER;
        $this->pass = DB_PASS;
        $this->db = DB_NAME;
        $this->dsn = "mysql:dbname=" . DB_NAME . ";host=" . DB_HOST;
    }

    function fetch($sql)
    {
        try {
            $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo 'Connection failed:' . $e->getMessage();
            exit();
        }
    }

    function execute($sql, $arrData = array(), $column = null)
    {
        try {
            $pdo = new PDO ($this->dsn, $this->user, $this->pass, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));
            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrData);
            $data = $pdo->lastInsertId($column);
            return $data;
        } catch (PDOException $e) {
            echo 'Connection failed:' . $e->getMessage();
            exit();
        }
    }

}
