# 導入方法

```
$ sudo mysql

mysql> create database DATABASE_NAME;
mysql> create user 'DATABASE_USER'@'%' identified by 'DATABASE_PASSWOED';
mysql> grant all on nya.* to nya@"%";
```

でデータベース作ってユーザー作って権限設定して

```
$ sudo mysql -u DATABASE_USER -p

mysql> use DATABASE_NAME
mysql> create table short(short int auto_increment, original MEDIUMTEXT, PRIMARY KEY (short));
mysql> insert into short(short, original) value (2704, "https://jun50.jp");
mysql> delete from short;
```

これで完了です。
あとはmod_rewrite有効化したりあーだこーだと