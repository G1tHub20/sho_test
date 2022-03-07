<?php
require('library.php');

$target[0] = '1889年の[2月11日]に、大日本帝国憲法が発布された。';
$target[1] = '議会に衆議院と［貴族院］の二院制が採用されることも定められた。';
d($target);

for ($i=0; $i<2; $i++) {
  // $target2 = str_replace('院', '忍', $target[$i]);
  $target[$i] = str_replace('［', '[', $target[$i]);
  $target[$i] = str_replace('］', ']', $target[$i]);
}

d($target);
d($target);

?>


<form method="post" action="">
  <p>テストの科目を選んでください。</p>
  科目：
    <select name="subject" required>
      <option hidden>ここから選択</option>
      <option value="国語">国語</option>
      <option value="数学">数学</option>
      <option value="英語">英語</option>
      <option value="理科">理科</option>
      <option value="社会">社会</option>
      <option value="その他">その他</option>
    </select>

    <button type="submit">これで作成</button>
</form>