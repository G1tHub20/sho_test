<?php
require('library.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $subject = $_POST['subject'];
  d($subject);
  // echo $subject;
} ?>


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