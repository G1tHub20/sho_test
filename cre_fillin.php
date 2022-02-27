<?php
require('library.php');
session_start();

$form = [];
$error = [];
$subject = [];
$id = $_SESSION['user_id'];
$check = [
  '0' => '',
  '1' => '',
  '2' => '',
  '3' => '',
  '4' => '',
];
$placeholder = " placeholder='1889年の[2月11日]に、大日本帝国憲法が発布された。'";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  echo 'submit';

  $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING); //←取得できていない
  d($subject);
  $type = '穴埋め';
  $addition = 'ここにテストの情報を記載する';

  for ($i = 0; $i < 5; $i++) {
    $target[] = $_POST['no' . $i];    
    d($target);

    //チェック１：角括弧（[]）を含むか検査
    if (strpos($target[$i],'[') == false){
      $check[$i] = '[無し';
    }
    if (strpos($target[$i],']') == false){
      $check[$i] .= ']無し';
    }
    d($check);
    d(array_keys($check));


  // チェック１がOKなら
  if (empty($check)) {
    echo '文字列チェックOK';

    // 切り出し
    $start[] = mb_strpos($target[$i], '[') + 1; //開始位置（+1する）
    $end[] = mb_strpos($target[$i], ']'); //終了位置
    echo '開始位置';
    d($start[$i]);
    echo '終了位置';
    d($end[$i]);
    $length[] = $end[$i] - $start[$i]; //文字列長（終了位置 - 開始位置）
    $mid[] = mb_substr($target[$i], $start[$i], $length[$i]); //対象文字列、開始位置、文字列長
    d($mid[$i]);

    // 置換
    $new_target[] = str_replace($mid[$i], '　　　', $target[$i]);
    d($new_target[$i]);
    
    // $check = array_filter( $check, "strlen" ); //空要素を取り除く


  // DB接続
  $dbh = dbconnect();

  // test_idを決定
  $sql = "SELECT MAX(id)+1 AS test_id FROM test";
  $stmt = $dbh->query($sql);
  $row = $stmt->fetch();
  $test_id = $row['test_id'];
  d($test_id);

  // 最初のquestion_idを決定
  $sql = "SELECT MAX(id)+1 AS question_id FROM questions";
  $stmt = $dbh->query($sql);
  $row2 = $stmt->fetch();
  $question_id = $row2['question_id'];
  d($question_id);


  // testテーブルに登録
  $subject = 'その他';

  $stmt2 = $dbh->prepare("INSERT INTO test(type, subject, user_id, addition) VALUES (:type, :subject, :user_id, :addition)");
  $stmt2->bindValue(':type', $type);
  $stmt2->bindValue(':subject', $subject);
  $stmt2->bindValue(':user_id', $id);
  $stmt2->bindValue(':addition', $addition);
  $result = $stmt2->execute();

  if ($result) {
  // questionsテーブルに登録
  $sql1 = "INSERT INTO questions (question, test_id) VALUES
  ('$new_target[0]', $test_id),
  ('$new_target[1]', $test_id),
  ('$new_target[2]', $test_id),
  ('$new_target[3]', $test_id),
  ('$new_target[4]', $test_id)";
  $result = $dbh->query($sql1);
  }

  // answersテーブルに登録
  if ($result) {
  $sql2 = "INSERT INTO answers (correct, question_id) VALUES
  ('$mid[0]', $question_id),
  ('$mid[1]', $question_id+1),
  ('$mid[2]', $question_id+2),
  ('$mid[3]', $question_id+3),
  ('$mid[4]', $question_id+4)";
  $result = $dbh->query($sql2);
  }


  if ($result) {
    echo 'DBに登録完了';
  }

} else {
  echo '<p>文字列チェックNG！</p>';
  echo '<p>入力し直してください</p>';
}

}
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>作成｜小テスト</title>
</head>
<body>
<?php include 'inc/header.php'; ?>
  <h1>テストを作成</h1>
  <h2>穴埋め問題</h2>
  <form method="post" action="">
    <p>科目：<input type="text" name="subject" list="example" placeholder="選択肢になければ入力" title="※選び直す場合は入力を削除" required></p>
    <datalist id="example">
      <option value="国語"></option>
      <option value="数学"></option>
      <option value="英語"></option>
      <option value="歴史"></option>
      <option value="理科"></option>
    </datalist>
    <p>穴埋め部分を<b>[ ]</b>で囲んで問題文を作成してください。</p>

    <?php for ($i = 0; $i < 5; $i++): ?>
      <h3>問<?php echo $i + 1 ?></h3>
      <textarea name="no<?php echo $i; ?>" rows="5" cols="44" <?php if ($i === 0) echo $placeholder; ?>><?php echo $target[$i]; ?></textarea><br>
    <?php endfor; ?>
    <button type="submit">これで作成</button>
  </form>


</body>
</html>