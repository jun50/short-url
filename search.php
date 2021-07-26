<?php
require_once("config.php");
require_once("base_convert62.php");

if (!isset($_GET["short"]) || empty($_GET["short"])) {
    // shortがなかったら400吐いて、終わり！
    $array = array(
        "error" => "short is required."
    );
    header("HTTP/1.1 400 Bad Request");
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($array);
    exit;
}

$dsn = "mysql:host=" . $dbhost . ";port=" . $dbport . ";dbname=" . $dbname;

try {
    $dbh = new PDO($dsn, $dbuser, $dbpassword);
} catch (PDOException $e) {
    var_dump($e);
    // 接続できなかったら500吐いて、終わり！
    $array = array(
        "error" => "Database error"
    );
    header("HTTP/1.1 500 Internal Server Error");
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($array);
    exit;
}

$sql = "select * from short where short=:short";
$prepare = $dbh->prepare($sql);
$prepare->bindValue(':short', (string)dohex2dec($_GET["short"]), PDO::PARAM_STR);
$prepare->execute();
$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

$array = array(
    "original-url" => $result[0]["original"],
    "short-url" => $base_url . dec2dohex((int)$result[0]["short"]),
    "base-url" => $base_url,
    "short" => dec2dohex((int)$result[0]["short"])
);
header("Content-Type: application/json; charset=utf-8");
echo json_encode($array);