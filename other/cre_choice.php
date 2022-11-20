<?php
$form = [];
$error = [];

$form['one'] = filter_input(INPUT_POST, 'one', FILTER_SANITIZE_STRING);
$form['two'] = filter_input(INPUT_POST, 'two', FILTER_SANITIZE_STRING);
$form['three'] = filter_input(INPUT_POST, 'three', FILTER_SANITIZE_STRING);
$form['four'] = filter_input(INPUT_POST, 'four', FILTER_SANITIZE_STRING);
$form['five'] = filter_input(INPUT_POST, 'five', FILTER_SANITIZE_STRING);
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
  <h1>作成（選択問題）</h1>
  <h2>選択問題</h2>
    <p>問題文を入力し、選択肢を4つ設定。正解の選択肢にチェックを入れてください。</p>

  <form method="post" action="">
    <h3>問1</h3>
    <textarea name="one" rows="5" cols="44" placeholder="（例）日本の首都は[東京]である。">世界恐慌に対してアメリカがとった政策は何か？</textarea><br>
      <div>1<input type="text" placeholder="大阪" value="ブロック経済"><input type="radio" name="correct" value="1"></div>
      <div>2<input type="text" placeholder="京都" value="共産制作"><input type="radio" name="correct" value="2"></div>
      <div>3<input type="text" placeholder="名古屋" value="ニューディール政策"><input type="radio" name="correct" value="3"></div>
      <div>4<input type="text" placeholder="広島" value="広島"><input type="radio" name="correct" value="4"></div>
    <h3>問2</h3>
    <textarea name="two" rows="5" cols="44">1929年に起きた世界恐慌はどこの国が発端となったか？</textarea><br>
      <div>1<input type="text" value="日本"><input type="radio" name="correct" value="1"></div>
      <div>2<input type="text" value="アメリカ"><input type="radio" name="correct" value="2"></div>
      <div>3<input type="text" value="イギリス"><input type="radio" name="correct" value="3"></div>
      <div>4<input type="text" value="ドイツ"><input type="radio" name="correct" value="4"></div>
    <h3>問3</h3>
    <textarea name="three" rows="5" cols="44">世界恐慌の際、イギリスやフランスがとった経済体制を何というか？</textarea><br>
      <div>1<input type="text" value="デフレ経済"><input type="radio" name="correct" value="1"></div>
      <div>2<input type="text" value="FTA経済"><input type="radio" name="correct" value="2"></div>
      <div>3<input type="text" value="バブル経済"><input type="radio" name="correct" value="3"></div>
      <div>4<input type="text" value="ブロック経済"><input type="radio" name="correct" value="4"></div>
    <h3>問3</h3>
    <textarea rows="four" cols="44">1933年にドイツで政権を握ったファシズム政党を何というか？</textarea><br>
      <div>1<input type="text" value="ナチス党"><input type="radio" name="correct" value="1"></div>
      <div>2<input type="text" value="ネオナチ党"><input type="radio" name="correct" value="2"></div>
      <div>3<input type="text" value="ファシスト党"><input type="radio" name="correct" value="3"></div>
      <div>4<input type="text" value="共産党"><input type="radio" name="correct" value="4"></div>
    <h3>問4 name="one"</h3>
    <textarea rows="five" cols="44">ファシスト党はヨーロッパのどこの国の政党か？</textarea><br>
      <div>1<input type="text" value="オランダ"><input type="radio" name="correct" value="1"></div>
      <div>2<input type="text" value="フランス"><input type="radio" name="correct" value="2"></div>
      <div>3<input type="text" value="イタリア"><input type="radio" name="correct" value="3"></div>
      <div>4<input type="text" value="スペイン"><input type="radio" name="correct" value="4"></div>

    <?php
      //  echo htmlspecialchars($form['one'], ENT_QUOTES);
        var_dump($form);
    ?>
    
    <button type="submit">これで作成</button>
  </form>

</body>
</html>