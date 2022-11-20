<?php
require_once('library.php');
session_start();

$error = [];
$id = $_SESSION['user_id'];
$check = [
  '0' => '',
  '1' => '',
  '2' => '',
  '3' => '',
  '4' => '',
];
$message = '';
$isReady = false;
$placeholder = " placeholder='1889年の[2月11日]に、大日本帝国憲法が発布された。'";
$result3 = false;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // echo 'submit';

  $subject = $_POST['subject']; //←配列ではなく普通の変数として取得される
  d($subject);
  $type = '穴埋め';
  $addition = $_POST['addition'];
  d($addition);

  // ■ 1：チェック：角括弧（[]）を含むか検査
  // echo '<p>チェック開始</p>';
  for ($i = 0; $i < 5; $i++) {
    $target[] = $_POST['no' . $i];

    d($target);
    // 全角角括弧の置換
    $target[$i] = str_replace('［', '[', $target[$i]);
    $target[$i] = str_replace('］', ']', $target[$i]);
    d($target);
    
    if (strpos($target[$i],'[') == false){
      $check[$i] = '「 <b>[</b> 」をつけてください。';
    }
    if (strpos($target[$i],']') == false){
      $check[$i] .= '「<b>]</b>」をつけてください。';
    }
  }
  d($target);


// ■ 2：穴埋め化
if (count(array_filter($check)) == 0) { //配列のキーの要素の有無を確認する
  // echo '全てエラー無し';
  for ($i = 0; $i < 5; $i++) {

  // 切り出し
  $start[] = mb_strpos($target[$i], '[') + 1; //開始位置（+1する） // mb_strpos — 文字列の中に指定した文字列が最初に現れる位置を見つける
  $end[] = mb_strpos($target[$i], ']'); //終了位置
  $length[] = $end[$i] - $start[$i]; //文字列長（終了位置 - 開始位置）
  $mid[] = mb_substr($target[$i], $start[$i], $length[$i]); //対象文字列、開始位置、文字列長

  // 置換
  $new_target[] = str_replace($mid[$i], '　　　', $target[$i]);
}
  d($mid);
  d($new_target);
  $isReady = true;

} else {
  echo 'エラーあり';
}

// ■ チェックと穴埋め化が済んだらDBに登録
if ($isReady) {
  // DB接続
  $dbh = dbconnect();

  // 1：testテーブル
  // test_idを決定
  $sql = "SELECT MAX(id)+1 AS test_id FROM tests";
  $stmt = $dbh->query($sql);
  $row = $stmt->fetch();
  $test_id = $row['test_id'];
  d($test_id);

  // 最初のquestion_idを決定
  // $sql = "SELECT MAX(id)+1 AS question_id FROM questions";

  // $stmt = $dbh->query($sql);
  // $row2 = $stmt->fetch();
  // $question_id = $row2['question_id'];
  // d($question_id);

  // testテーブルに登録
  $type = "穴埋め";

  $stmt1 = $dbh->prepare("INSERT INTO tests(type, subject, user_id, addition) VALUES (:type, :subject, :user_id, :addition)");
  $stmt1->bindValue(':type', $type);
  $stmt1->bindValue(':subject', $subject);
  $stmt1->bindValue(':user_id', $id);
  $stmt1->bindValue(':addition', $addition);
  $result1 = $stmt1->execute();

  // echo '$result1：' . $result1;

  // 2：questionsテーブル
    // question_idを決定
    // $sql = "SELECT MAX(id)+1 AS question_id FROM questions";
    $stmt2 = $dbh->query("SELECT MAX(id)+1 AS question_id FROM questions");
    $row = $stmt2->fetch();
    $question_id = $row['question_id'];
    
    if ($result1 == 1) {
      $sql2 = "INSERT INTO questions (question, test_id) VALUES
    ('$new_target[0]', $test_id),
    ('$new_target[1]', $test_id),
    ('$new_target[2]', $test_id),
    ('$new_target[3]', $test_id),
    ('$new_target[4]', $test_id)";
    $result2 = $dbh->query($sql2);
    
    d($result2);
  }
  
  // 3：answersテーブル
  d($question_id);
  d($result2);

  if ($result2 != false) {
  $sql2 = "INSERT INTO answers (correct, question_id) VALUES
  ('$mid[0]', $question_id),
  ('$mid[1]', $question_id+1),
  ('$mid[2]', $question_id+2),
  ('$mid[3]', $question_id+3),
  ('$mid[4]', $question_id+4)";
  $result3 = $dbh->query($sql2);
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
  <link rel="stylesheet" href="css\style.css">
  <title>作成｜小テスト</title>
</head>
<body>
<?php include 'inc/header.php'; ?>
<div class="container">
<h1>テスト（穴埋め問題）作成</h1>
<h2></h2>
<?php echo $message; ?>
  <form method="post" action="">
  <p>テスト科目を選んでください</p>
  科目：
    <select name="subject" required>
      <option value="" hidden>選択してください </option>
      <option value="国語">国語</option>
      <option value="数学">数学</option>
      <option value="英語">英語</option>
      <option value="理科">理科</option>
      <option value="社会">社会</option>
      <option value="その他">その他</option>
    </select>
    <p title="（注意）全角の[ ]は使用できません">穴埋め部分を<b>[ ]</b>で囲んで5つの問題文を作成してください。</p>

    <?php for ($i = 0; $i < 5; $i++): ?>
      <h3>問<?php echo $i + 1 ?></h3>
      <textarea name="no<?php echo $i; ?>" rows="4" cols="35" <?php if ($i === 0) echo $placeholder; ?> required><?php if (isset($target[$i]) && ($target[$i] !== '')) { echo $target[$i];} ?></textarea>
      <p class="error"><?php echo $check[$i]; ?></p>
    <?php endfor; ?>
    <p>補足（任意）</p>
    <textarea name="addition" rows="2" cols="25" placeholder="内閣と憲法について"><?php if (isset($_POST['addition'])) { echo $_POST['addition']; } ?></textarea><br>
    <?php if (!$result3) { echo('<button type="submit">これで作成</button>'); } ?>
  </form>
  <?php
  if ($result3 != false) {
    // echo 'DBに登録完了';
    echo '<h2>テストの作成完了！</h2>';
    echo "<p><a href= 'index.php'>Home</a></p>";
  }
  ?>

<footer class="footer">&nbsp;</footer>
</div>
</body>
</html>