<?php
require_once 'goutte.phar';

use Goutte\Client;

class Wars_model extends CI_Model {

    public function __construct()
    {
    }

    // 対局履歴データの更新
    public function update_history()
    {
        $max_page = $this->config->item('my_max_page');

        // 処理済みの最終対局日時を取得
        $last_time = $this->read_lasttime();

        for ($i=0; $i<$max_page; $i++)
        {
            $url = $this->config->item('my_history_url') . ($i*10);
            if (!$this->scrape_page($url, $last_time))
            {
                break;
            }
        }

        return;
    }

    // 対局履歴ページをスクレイピングしてデータ取得
    public function scrape_page($url, $last_time)
    {
        $records = array();
        $newest_time = 0;

        $client = new Client();

        log_message('debug', 'Request: ' . $url);

        $crawler = $client->request('GET', $url);

        $dom = $crawler->filter('div.contents');
        if (!count($dom))
        {
            log_message('debug', 'Data not found');
            return false;
        }

        $dom->each(function ($node) use (&$records, &$newest_time, $last_time)
        {
            // パーマリンク取得
            $permalink = '';
            $dom_link = $node->filter('div.short_btn1 a');
            $dom_link->each(function ($node_link) use (&$permalink) {
                $permalink = $node_link->attr('href');
            });
            $ending_time = str_replace('_', '', substr($permalink, -15));
            if ($ending_time > $newest_time)
            {
                $newest_time = $ending_time;
            }

            // ユーザー取得
            $users = array();
            $dom_user = $node->filter('td');
            $dom_user->each(function ($node_user) use (&$users) {
                $_tmp = $node_user->text();
                if ($_tmp)
                {
                    $_users = explode(' ', $_tmp);
                    $users[] = $_users[0];  // ユーザー名
                    $users[] = $_users[1];  // 級段
                }
            });

            // 勝敗取得
            $results = array();
            $dom_result = $node->filter('img.setting_title');
            $dom_result->each(function ($node_result) use (&$results) {
                $_tmp = $node_result->attr('alt');
                if ($_tmp)
                {
                    $results[] = $_tmp;
                }
            });

            if ($last_time < $ending_time)
            {
                // CSV データ
                $records[] = array(
                    $ending_time,
                    $users[0],
                    $users[1],
                    $results[0],
                    $users[2],
                    $users[3],
                    $results[1],
                    $permalink,
                );
                log_message('debug', 'Save: '.$ending_time);
            }
            else
            {
                log_message('debug', 'Does not save: '.$ending_time);
            }
        });

        // 履歴CSV書き込み
        if (!empty($records))
        {
            $this->write_history($records);
            log_message('debug', "Save ".count($records)." counts");
        }

        // 最終対局日時書き込み
        $this->write_lasttime($newest_time);

        return true;
    }

    // 履歴CSV読み込み
    public function read_history()
    {
        $records = array();

        $history_file = $this->config->item('my_history_file');
        if (!file_exists($history_file))
        {
            return $records;
        }

        // CSVレコードの並び順が一定になってないので日時でソート
        if ($fp = fopen($history_file, "r"))
        {
            while (($row = fgetcsv($fp)) !== false)
            {
                $records[$row[0]] = $row;
            }
        }
        rsort($records);

        return $records;
    }

    // 履歴CSV書き込み
    public function write_history($records)
    {
        if (!is_array($records))
        {
            return falser;
        }

        $fp = fopen($this->config->item('my_history_file'), 'a');
        foreach ($records as $rows)
        {
            fputcsv($fp, $rows);
        }
        fclose($fp);

        return true;
    }

    // 最終対局日時読み込み
    public function read_lasttime()
    {
        $lasttime_file = $this->config->item('my_lasttime_file');

        if (file_exists($lasttime_file))
        {
            $lasttime = trim(file_get_contents($lasttime_file));
        }
        else
        {
            $lasttime = 0;
        }

        return $lasttime;
    }

    // 最終対局日時書き込み
    public function write_lasttime($lasttime)
    {
        // 現在保存されているより新しい日時だったら更新する
        $current_lasttime = $this->read_lasttime();
        if ($lasttime > $current_lasttime)
        {
            file_put_contents($this->config->item('my_lasttime_file'), $lasttime);
            log_message('debug', "Last time updated to ".$lasttime);
        }

        return true;
    }
}
