<?php require DIR.'/viewPage/top.php'; ?>
<?php require DIR.'/viewPage/menu.php'; ?>
<h1 class="h1"><?= $pageTitle ?></h1>
<?php if(isset($_SESSION['success'])) {
  echo $_SESSION['success'];
  unset($_SESSION['success']);
}
?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">ID #</th>
      <th scope="col">Account number</th>
      <th scope="col">Name</th>
      <th scope="col">Surname</th>
      <th scope="col">Balance</th>
      <th scope="col">Withdraw Funds</th>
      <th scope="col">Add Funds</th>
      <th scope="col">Removal</th>
    </tr>
  </thead>
  <tbody>

  <?php 
  usort($users, function ($user1, $user2) {
    return $user1 -> surname <=> $user2 -> surname;
});
  foreach($users as $user) {
    $balanceCurr = $_SESSION['Currency'][0] * $user -> balance; 
    $balanceCurr = round($balanceCurr, 2);
    $curr = $_SESSION['Currency'][1];
      echo '<tr>
      <th scope="row">'.$user -> uniqID.'</th>
      <td>'.$user -> accId."</td>
      <td>".$user ->name."</td>
      <td>".$user -> surname."</td>
      <td>".$user -> balance." EUR<br>(".$balanceCurr." ".$curr.")</td> 
      <td><a class=\"btn btn-primary\" href=\"edit2/".$user -> uniqID."\" role=\"button\">Withdraw funds</a></td>
      <td><a class=\"btn btn-primary\" href=\"edit/".$user -> uniqID."\" role=\"button\">Add Funds</a></td>
      <td><form action=\"delete/".$user -> uniqID."\" method=\"post\">
      <button type=\"submit\" class=\"btn btn-primary\">Delete Account</button></form></td>
    </tr>" ;
  }
  unset($_SESSION['Currency']);
   ?>
  </tbody>
</table>
<?php require DIR.'/viewPage/bottom.php'; ?>