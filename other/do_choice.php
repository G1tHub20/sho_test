<?php
require('config.php');

// 全問題文を取得
$stmt = $dbh->prepare('SELECT id as question_id, content FROM question WHERE test_id=:test_id');

$choice = array(4);
if (!$stmt) {
  die($dbh->error);
}
$test_id = $_GET['test'];

$stmt->bindValue(':test_id', $test_id);
$stmt->execute();

// 正答を取得


// foreach ($stmt as $row) {
//   $question_id[] = $row['question_id'];
// }

// var_dump($question_id);

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
  <form method="post" action="kaito.php">
    <p>正しいものを選択肢から一つ選びなさい。</p>

    <?php foreach ($stmt as $row): ?>
      <h3>問<?php echo $i ?></h3>
        <p><?php echo $row['content'] ?></p>
        <?php 
        $stmt2 = $dbh->prepare('SELECT id, content, is_answer FROM choice WHERE question_id=:question_id');
        $stmt2->bindValue(':question_id', $row['question_id']);
        $stmt2->execute();

        $stmt3 = $dbh->prepare('SELECT id, content, is_answer FROM choice WHERE question_id=:question_id AND is_answer=1');
        $stmt3->bindValue(':question_id', $row['question_id']);
        $kai = $stmt3->execute();
        var_dump($kai);
        ?>
        <select name="ans<?php echo $row['question_id'] ?>" size="4">
        <?php foreach ($stmt2 as $row2): ?>
          <option value="<?php echo $row2['id'] ?>"><?php echo $row2['content'] ?></option>
        <?php endforeach; ?>
        </select>
          <?php $i = $i + 1; ?>
    <?php endforeach; ?>
    <br>
    <button type="submit">決定</button>
  </form>
</body>
</html>