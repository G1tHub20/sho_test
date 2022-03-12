<?php
require('library.php');
session_start();

// if (isset($_GET['test']) ) {
// // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   $test_id = filter_input(INPUT_GET, 'test', FILTER_SANITIZE_NUMBER_INT);
//   d($test_id);
// }

// 問題文を順に表示
// if (isset($_POST['next'])) {
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $i = $_POST['var'];

  $_SESSION['answer'][] = $_POST['no' . $i];

  $i++; // 問題番号をカウントアップ
  $_POST['var'] = $i;

  d($_SESSION['answer']);

} else {
  // echo '解答開始前';
  // $data = $_SESSION['question']; //POST送信で消えてしまう
  d($_SESSION['question']);

  // $form = [
  //   0 => '',
  //   1 => '',
  //   2 => '',
  //   3 => '',
  //   4 => ''
  // ];

  $i = 1; // 問題番号カウントアップ用
  $_SESSION['answer'] = array();
}


if ($i <= 5) {
  $button = '次の問題';

  if ($i === 5){
    // 最終問題
    $button = '解答終了';
  }

$question_form = <<<END
<h3>問 {$i}／5</h3>
<form action="" method="post">
<p>次の[　]に当てはまる語句を答えなさい。</p>
  <p>{$_SESSION['question'][$i-1]['question']}</p>
  <div class="input_wrapper"><input type="text" name="no{$i}" autofocus></div>
  <input type="hidden" name='var' value="{$i}">
  <br>
  <div class="button_wrapper" name="next"><button type="submit">{$button}</button></div>
</form>
<button class="short" onclick="location.href='./exams.php'">退席</button>
END;
} else {
  // 全問解答し終えたら
$question_form = <<<END2
  <h3>お疲れ様でした！</h3>
  <form action="result.php" method="post">
    <br>
    <div class="button_wrapper" name="next"><button type="submit">提出する</button></div>
  </form>
END2;
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
  <?php echo $question_form; ?>

  <footer class="footer">&nbsp;</footer>
</div>
</body>
</html>


