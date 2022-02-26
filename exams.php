<?php
require('library.php');
session_start();

// テスト一覧の取得
$dbh = dbconnect();
$stmt = $dbh->query("SELECT CONCAT('test', id) as test_id, id, type, subject, user_id, addition, created, avg_score, takers FROM test ORDER BY id DESC");


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>テスト一覧｜小テスト</title>
</head>
<body>
<?php include 'inc/header.php'; ?>
  <h1>テスト一覧</h1>

  <table>
    <tr><th>テスト名</th><th>ジャンル</th><th>科目</th><th>平均点</th><th>受験者数</th><th>受験</th></tr>
    <?php foreach ($stmt as $row): ?>
      <tr><td><?php echo $row['test_id'] ?></td><td><?php echo $row['type'] ?></td><td><?php echo $row['subject'] ?>
    </td><td><?php echo $row['avg_score'] ?></td><td><?php echo $row['takers'] ?></td><td><a href="take_exam.php?test=<?php echo $row['id'] ?>">受験</a></td></tr>
    <?php endforeach; ?>
  </table>

</body>
</html>