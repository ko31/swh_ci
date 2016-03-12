<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>View</title>
<style>
table {
    width: 50%;
    border-collapse: collapse;
    border: solid 1px #222;
}
th {
    padding: 5px;
    background-color: #eee;
    border: 1px solid #222;
}
td {
    padding: 5px;
    border: 1px solid #222;
}
</style>
</head>
<body>
<p><a href="<?php echo site_url('/');?>">戻る</a></p>
<table>
    <tr>
        <th>&nbsp;</th>
        <th>対局数</th>
        <th>勝</th>
        <th>負</th>
        <th>勝率</th>
    </tr>
    <tr>
        <th>先手</th>
        <td><?php echo $records['game_count_sente'];?></td>
        <td><?php echo $records['win_sente'];?></td>
        <td><?php echo $records['lose_sente'];?></td>
        <td><?php echo $records['win_rate_sente'];?></td>
    </tr>
    <tr>
        <th>後手</th>
        <td><?php echo $records['game_count_gote'];?></td>
        <td><?php echo $records['win_gote'];?></td>
        <td><?php echo $records['lose_gote'];?></td>
        <td><?php echo $records['win_rate_gote'];?></td>
    </tr>
    <tr>
        <th>合計</th>
        <td><?php echo $records['game_count'];?></td>
        <td><?php echo $records['win'];?></td>
        <td><?php echo $records['lose'];?></td>
        <td><?php echo $records['win_rate'];?></td>
    </tr>
</table>
</body>
</html>
