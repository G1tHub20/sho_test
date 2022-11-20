<?php
require_once('library.php');
session_start();

// テスト一覧の取得
$dbh = dbconnect();
$stmt = $dbh->query("SELECT * FROM tests");
// $stmt = $dbh->query("SELECT id, `type`, subject, user_id, addition, created_at, avg_score, takers FROM tests ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css\style.css">
  <title>テスト一覧｜小テスト</title>
</head>
<body>
<?php include 'inc/header.php'; ?>
<div class="container">
  <h1>テスト一覧</h1>

  <table>
    <tr><th>テスト名</th><!-- <th>ジャンル</th>--><th>科目</th><th>平均点</th><th>受験者数</th><th></th></tr>
    <?php foreach ($stmt as $row): ?>
      <tr><td><?php echo "test" . substr($row['id'], -3) ?></td><td><?php echo $row['subject'] ?>
    </td><td><?php echo $row['avg_score'] ?></td><td><?php echo $row['takers'] ?></td><td><button onclick="location.href='take_exam.php?test=<?php echo $row['id'] ?>'">受験</button></td></tr>
    <?php endforeach; ?>
  </table>
</div>
</body>
</html>