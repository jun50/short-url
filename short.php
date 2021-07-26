<?php
require("config.php");
require_once("base_convert62.php");

if (!isset($_GET["short"]) || empty($_GET["short"])){
    header('Location: ' . $redirect_url);
    exit;
}

$dsn = "mysql:host=" . $dbhost . ";port=" . $dbport . ";dbname=" . $dbname;

try {
    $dbh = new PDO($dsn, $dbuser, $dbpassword);
} catch (PDOException $e) {
    // 接続できなかったらデフォルトのリダイレクト先へ
    header('Location: ' . $redirect_url);
    exit;
}

$sql = "select * from short where short=:short";
$prepare = $dbh->prepare($sql);
$prepare->bindValue(':short', (string)dohex2dec($_GET["short"]), PDO::PARAM_STR);
$prepare->execute();
$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

header('Location: ' . $result[0]["original"]);