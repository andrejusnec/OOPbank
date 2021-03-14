<? //php require 'C:\xampp\htdocs\php_proj\OOPbank\default.php'; ?>
<?php require DIR.'/viewPage/top.php'; ?>
<?php require DIR.'/viewPage/menu.php'; ?>
<h1 class="h1"><?= $pageTitle ?></h1>
<?php if(isset($errorMsg)) {
    echo $errorMsg;
    unset($errorMsg);
    unset($pageTitle);
}
?>
<h1><?= $user -> name.' '.$user -> surname ?> account</h1><br>
<h3>Account's ID# <?= $user -> uniqID ?> Current balance: <?= $user -> balance ?> EUR</h3><br>
<form action="<?= URL ?>addFunds/<?= $user -> uniqID ?>" method="post">
  <div class="input-group mb-3">
  <span class="input-group-text">€</span>
  <input type="text" class="form-control" name="funds" aria-label="Amount (to the nearest dollar)">
</div>
<li id="color" class="list-group-item flex-fill"><button class="btn btn-primary" 
name ="addbtn" type="submit">Add to account</button>
<div style="display:inline-block; margin-left:10px"><a class="btn btn-primary" href="<?= URL ?>">Main menu</a></div></li>
</form>
<?php require DIR.'/viewPage/bottom.php'; ?>