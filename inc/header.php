<header>
  <?php
    $id = $_SESSION['user_id']; 
    $user_id = 'user' . sprintf('%03d', $id);
  ?>
  <a href="./index.php" class="home"><img src="img/home_icon.svg" alt="HOME"></a>
  <!-- <button onclick="location.href='./index.php'">Home</button> -->
  <p class="user"><?php echo $user_id  . ' さん'; ?></p>
</header>
