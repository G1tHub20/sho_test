<?php
require_once('library.php');
session_start();

$test_id = filter_input(INPUT_GET, 'test', FILTER_SANITIZE_NUMBER_INT);

// DB接続
$dbh = dbconnect();

// 問題文を取得
$stmt = $dbh->prepare("SELECT q.id as id, question, correct FROM questions q, answers a WHERE test_id=:test_id AND q.id=a.question_id ORDER BY q.id ASC");
$stmt->bindValue(':test_id', $test_id, PDO::PARAM_INT);
$stmt->execute();

$data = [];

while ($row = $stmt->fetch()) {
  $data[] = $row;
}

// テスト情報を取得
// echo '問題文を取得'. '<br>';
$stmt = $dbh->prepare('SELECT id, type, subject, user_id, addition FROM tests WHERE id=:test_id');
$stmt->bindValue(':test_id', $test_id);
$stmt->execute();
$test = $stmt->fetch(PDO::FETCH_ASSOC);
d($test);

// 正答を取得
// echo '正答を取得'. '<br>';

if (isset($test_id)) {
  $_SESSION['question'] = $data;
  $_SESSION['test'] = $test;

  // echo 'セッション（question、test）に保存'. '<br>';
  d($_SESSION['question']);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css\style.css">
  <title>解答｜小テスト</title>
</head>
<body>
<?php include 'inc/header.php'; ?>
<div class="container">
  <h1>解答</h1>

 <?php //echo sprintf('%03d', $test_id); ?>
  <h2>test<?php echo substr($test_id, -3); ?></h2>
  <!-- <p>形式：<?php echo $test['type']; ?></p> -->
  <p>科目：<?php echo $test['subject']; ?></p>
  <p>作成者：user<?php echo sprintf('%03d', $test['user_id']); ?></p>
  <p>補足：<?php echo $test['addition']; ?></p>
  <button onclick="location.href='./do_fillin.php?test=<?php echo $test_id; ?>'">開始する</button>

  <footer class="footer">&nbsp;</footer>
</div>
</body>
</html>