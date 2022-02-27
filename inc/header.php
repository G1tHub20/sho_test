<header>
  <?php
    $id = $_SESSION['user_id']; 
    $user_id = 'user' . sprintf('%03d', $id);
  ?>
  <p><a href= "index.php">Home</a><?php echo '　' . $user_id  . ' さん</p>'; ?></p>
</header>
