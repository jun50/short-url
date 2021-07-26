<?php
// データベースに関する設定です
$dbhost = "127.0.0.1";
$dbport = 3306;
$dbname = "database name";
$dbuser = "database username";
$dbpassword = "database password";

// https://ex.example.com/short/HgaJ のようなものを作りたければ https://ex.example.com/short/
$base_url = "https://ex.example.com/short/";

// 存在しない短縮URLにアクセスされた場合に飛ばすページ
$redirect_url = "https://google.com/";