<?php
require_once('library.php');
session_start();

// 新規ユーザー（セッションがない）なら
if (!isset($_SESSION['user_id'])) {
    $dbh = dbconnect();
    $stmt1 = $dbh->query("SELECT max(id) as id FROM users");
    $row = $stmt1->fetch();
    $user_id = 'user' . sprintf('%03d', $row['id'] + 1);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // DBにユーザーを登録
        $stmt2 = $dbh->prepare("INSERT INTO users (name) VALUES (:name)");
        $stmt2->bindValue(':name', $user_id);
        $result = $stmt2->execute();

        //セッションに格納
        if ($result) {
            $_SESSION['user_id'] = $row['id'] + 1;
        }
    }

} else {
    $user_id = 'user' . sprintf('%03d', $_SESSION['user_id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cre_fillin'])) {
        header('Location: cre_fillin.php');
        // echo 'fillin';
    } else if (isset($_POST['take_exam'])) {
        header('Location: exams.php');
        // echo 'take_exam';
    }
    exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="みんなで小テストするサイト"> <!-- ページの概要や要約 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- viewport -->
    <link rel="stylesheet" href="css\style.css">
    <link rel="icon" href="img/favicon.ico">  <!-- ファビコン -->
    <!-- リセットCSS -->
    <!-- <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css"> -->
    <!-- 'Klee One', 'Yusei Magic'（Googleフォント） -->
    <style>
        /* @import url('https://fonts.googleapis.com/css2?family=Klee+One&family=Yusei+Magic&display=swap'); */
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\style.css">
    <title>小テスト</title>
</head>

<body>
<header>
    <a href="./index.php" class="home"><img src="img/home_icon.svg" alt="HOME"></a>
    <p class="user"><?php echo ' ようこそ ' . $user_id  . ' さん'; ?></p>
</header>
<div class="container">
    <h1 id="title">小テスト</h1>


        <form method="post" action="">
        <div class="button_wrapper filler main"><button type="submit" name="cre_fillin">テストを作成</button></div>
            <!-- <li><button type="submit" name="">選択問題</button></li> -->
        <div class="button_wrapper main"><button type="submit" name="take_exam">テストを受ける</button></div>
        </form>

        <footer class="footer">&nbsp;</footer>
</div>
</body>