<?php require DIR.'/viewPage/top.php'; ?>
<?php require DIR.'/viewPage/menu.php'; ?>
<h1 class="h1"><?= $pageTitle ?></h1>
<?= $errorMsg ?? '<h2>Hello there</h2>' ?>
<form class="newForm" action="<?= URL ?>store" method="post">
    <div class="border-form img">
        <h1 class="h1">Sign up</h2>
<label class="inputasT" for="name">Name</label><br>
<input class="inputas" placeholder="Jon"  type="text" name="name" id=""><br>
<label class="inputasT" for="surname">Surname</label><br>
<input class="inputas" placeholder="Smith" pattern="([a-zA-Z]{3,30}\s*)+" type="text" name="surname" id=""><br>
<label class="inputasT" for="idNumber">Account number</label><br>
<input class="inputas" placeholder="<?php //$accountID = accExist(); $_SESSION['readonly'] = $accountID; echo $_SESSION['readonly'];?>"
 type="text" name="accNum" id=""><br>
<label class="inputasT" for="idNumber">Personal identification code</label><br>
<input class="inputas" placeholder="11 digits"  type="text" name="idNumber" id=""><br><br>
<li id="color" class="list-group-item flex-fill"><button class="btn btn-primary" name ="create" type="submit">Create</button></li>
</div>
</form>
<?php require DIR.'/viewPage/bottom.php'; ?>