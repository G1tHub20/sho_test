<header>
  <a href= "index.php">Home</a>
</header>
<?php
$id = $_SESSION['user_id'];
$user_id = 'user' . sprintf('%03d', $id);
echo $user_id  . ' さん';

?>