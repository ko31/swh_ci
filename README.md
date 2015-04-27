# 将棋ウォーズ対局履歴取得ツール（CodeIgniter版）

## 概要

* 将棋ウォーズの対局履歴ページをスクレイピングして対局データを保存するツールです。
* [CodeIgniter](http://www.codeigniter.com/) ベースに作られています。
* スクレイピングには [Goutte](https://github.com/FriendsOfPHP/Goutte) を使っています。

## 使い方

### インストール

ソースをチェックアウトします。

```
$ git clone git@github.com:ko31/swh_ci.git
```

logs ディレクトリに書き込み権限を与えておきます。

```
$ chmod 0777 swh_ci/application/logs
```

設定ファイルの将棋ウォーズユーザー名を自分のものに変更します。

```
$ vi application/config/development/config.php

// 将棋ウォーズのユーザー名
$config['my_user_name'] = 'ko31';
```

### 対局履歴データの取得

対局履歴データの取得はブラウザ、コマンドラインのいずれかから実行できます。

ブラウザから実行する場合、下記のような URL にアクセスします。（Document Root 下の swh_ci ディレクトリにインストールされている場合）

```
http://example.com/swh_ci/wars/update
```

コマンドラインから実行する場合、下記のようにコマンドを実行します。

```
$ cd /path/to/swh_ci
$ php index.php wars update
```

対局履歴データの取得が完了すると、swh_ci/application/logs/history.csv に対局履歴データが保存されます。

### 対局履歴データの閲覧

ブラウザから対局履歴データを一覧表示することができます。

下記のような URL にアクセスします。

```
http://example.com/swh_ci/
```

## 注意事項

* MIT ライセンスです。
* ご利用は自己責任でお願いします。
