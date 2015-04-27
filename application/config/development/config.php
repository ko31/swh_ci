<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// 将棋ウォーズのユーザー名
$config['my_user_name'] = 'ko31';

// 将棋ウォーズのユーザー名
$config['my_history_url'] = 'http://shogiwars.heroz.jp/users/history/' . $config['my_user_name'] . '?gtype=&start=';

// 履歴CSVファイル 
$config['my_history_file'] = APPPATH.'logs/history.csv';

// 最終対局日時データ
$config['my_lasttime_file'] = APPPATH.'logs/lasttime.dat';

// スクレイピングする最大ページ
$config['my_max_page'] = 10;

