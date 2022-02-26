<?php
require('library.php');
session_start();

$data = [];

$form = [
  0 => '',
  1 => '',
  2 => '',
  3 => '',
  4 => ''
];

// if (isset($_GET['test']) && isset($_SESSION['form'])) {
  $data = $_SESSION['question'];
  // d($data);

  $test_id = filter_input(INPUT_GET, 'test', FILTER_SANITIZE_NUMBER_INT);
  // }

$is_check = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  echo 'submit（提出された）<br>';
  $form[0] = filter_input(INPUT_POST, 'no1');
  $form[1] = filter_input(INPUT_POST, 'no2');
  $form[2] = filter_input(INPUT_POST, 'no3');
  $form[3] = filter_input(INPUT_POST, 'no4');
  $form[4] = filter_input(INPUT_POST, 'no5');

  $_SESSION['kaito'] = $form;

  $score = 0;

  // $form['11'] = filter_input(INPUT_POST, '11');
  d($form);

  // 正誤チェック
  // foreach ($form as $q) {
  for ($i = 0; $i < 5; $i++) {
    // d($q);
    // echo($data[$i]['answer']);
    if ($form[$i] === $data[$i]['answer']) {
      echo $i+1 . ':○<br>';
      $score += 20;
    } else {
      echo $i+1 . ':×<br>';
    }
}

$_SESSION['score'] = $score;



// 解答ページに遷移
if ($is_check) {
  header('Location: kaito.php');
  exit();
}
}

// 問題番号カウントアップ用
$i = 1;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>解答｜小テスト</title>
</head>
<body>
<?php include 'inc/header.php'; ?>
  <h1>解答</h1>
  <form method="post" action="">
    <!-- <p>次の空欄に当てはまる言葉を答えなさい。</p> -->
    <p>次の[　]に当てはまる語句を答えなさい。</p>

    <?php foreach ($data as $row): ?>
        <h3>問<?php echo $i ?></h3>
        <p><?php echo $row['question'] ?></p>
        <input type="text" name="no<?php echo $i ?>" value="<?php echo $form[$i-1]; ?>">
        <?php $i = $i + 1; ?>
    <?php endforeach; ?>

    <br>
    <button type="submit">提出する</button>
  </form>
</body>
</html>