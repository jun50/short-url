<?php
require_once("config.php");
require_once("base_convert62.php");

if($_SERVER["REQUEST_METHOD"] != "POST"){
    // POSTじゃなかったら405吐いて、終わり！
    $array = array(
        "error" => "405 Method Not Allowed"
    );
    header("HTTP/1.1 405 Method Not Allowed");
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($array);
    exit;
}

$contents = json_decode(file_get_contents("php://input"), true);

if (!isset($contents["original-url"]) || empty($contents["original-url"])) {
    // original-urlがなかったら400吐いて、終わり！
    $array = array(
        "error" => "original-url is required."
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

$sql = "insert into short (original) value (:original);";
$prepare = $dbh->prepare($sql);
$prepare->bindValue(':original', $contents["original-url"], PDO::PARAM_STR);
$prepare->execute();

$sql = "select * from short where original=:original;";
$prepare = $dbh->prepare($sql);
$prepare->bindValue(':original', $contents["original-url"], PDO::PARAM_STR);
$prepare->execute();
$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

$array = array(
    "original-url" => $result[0]["original"],
    "short-url" => $base_url . dec2dohex((int)$result[0]["short"])
);
header("Content-Type: application/json; charset=utf-8");
echo json_encode($array);
