<div class="topnav">
  <a class="active" href="<?= URL ?>">Main</a>
  <a href="<?= URL ?>create">Create</a>
  <a href="<?= URL ?>edit">Add funds</a>
  <a href="<?= URL ?>edit2">Withdraw funds</a>
  <a href="<?= URL ?>delete">Delete account</a>
  <div style="float:right">
      <div class="user" ><?= $_SESSION['user']['name'] ?></div>
      <a href="<?= URL ?>login.php?logout">Log Out</a>
      <a href="<?= URL ?>">TESO BANK</a>
      <img class="logo" src="<?= URL ?>img/eso.webp" alt="alt">
  </div>
</div>