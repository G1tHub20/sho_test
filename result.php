<?php
require_once('library.php');
session_start();

$score = 0;

$is_correct = [
  '0' => '',
  '1' => '',
  '2' => '',
  '3' => '',
  '4' => ''
];

if (isset($_SESSION['answer']) && isset($_SESSION['answer'])) {
  $answer = $_SESSION['answer'];
  d($answer);
}

if (isset($_SESSION['question'])) {
  $question = $_SESSION['question'];
  for ($i=0; $i<5; $i++) {
    $correct[] = $question[$i]['correct'];
  }
  d($correct);
}

// 確認用
for ($i=0; $i<5; $i++) {
  if ($answer[$i] === $correct[$i]) {
    $score += 20;
    $sign[] = '○';
  } else {
    // echo '問' . $i+1 . '=' . '×';
    $is_correct[$i] = false;
    $sign[] = '×';
  }
}

// d($is_correct);
// d($sign);

for ($i=0; $i<5; $i++) {
  $tmp_correct = "[" . $answer[$i] . "]";
  $question[$i] = str_replace('[　　　]', $tmp_correct, $question[$i]['question']);
}

$test_id = $_SESSION['test']['id'];
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // echo 'DBに反映';

// DBに受験履歴を反映
$dbh = dbconnect();
$stmt = $dbh->prepare('INSERT INTO histories (score, test_id, user_id) VALUES (:score, :test_id, :user_id);');
$stmt->bindValue(':score', $score, PDO::PARAM_INT);
$stmt->bindValue(':test_id', $test_id, PDO::PARAM_INT);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

// テストの情報を反映
// 平均点の取得
$stmt1 = $dbh->prepare('SELECT AVG(score) as avg_score FROM histories WHERE test_id=:test_id;');
$stmt1->bindValue(':test_id', $test_id, PDO::PARAM_INT);
$stmt1->execute();
$row1 = $stmt1->fetch();
$avg_score = round($row1['avg_score']);
// echo $avg_score;

//受験者数の取得
$stmt2 = $dbh->prepare('SELECT COUNT(*) AS takers FROM histories WHERE test_id=:test_id');
$stmt2->bindValue(':test_id', $test_id, PDO::PARAM_INT);
$stmt2->execute();
$row2 = $stmt2->fetch();
$takers = $row2['takers'];
// echo $takers;

$stmt3 = $dbh->prepare('UPDATE tests SET avg_score=:avg_score, takers=:takers WHERE id=:id');
$stmt3->bindValue(':avg_score', $avg_score, PDO::PARAM_INT);
$stmt3->bindValue(':takers', $takers, PDO::PARAM_INT);
$stmt3->bindValue(':id', $test_id, PDO::PARAM_INT);
$result = $stmt3->execute();

if ($result) {
  // echo '反映OK';
  header('Location: result.php');
  exit();
} else {
  // echo '反映NG';
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css\style.css">
  <title>解答ページ</title>
</head>
<body>
<?php include 'inc/header.php'; ?>
<div class="container">
<h1>答案用紙</h1>
<h2 class="red"><?php echo $score . '点'; ?></h2>
<p>次の[　]に当てはまる語句を答えなさい。</p>
<?php for ($i = 0; $i < 5; $i++): ?>
  <h3><span class="red"><?php echo $sign[$i]; ?></span>問<?php echo $i + 1 ?></h3>
  <?php echo $question[$i]; ?>
  <?php if ($is_correct[$i] === false): ?>
    <p><input type="text" class="red" value="<?php echo $correct[$i]; ?>" readonly></p>
  <?php endif; ?>
<?php endfor; ?>

<footer class="footer">&nbsp;</footer>
</div>
</body>
</html>