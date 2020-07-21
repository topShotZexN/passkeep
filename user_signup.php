<?php
include_once 'dbconnect.php';
$error = false;
if (isset($_POST['sign'])) {

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);

  $pass1 = trim($_POST['pass1']);
  $pass1 = strip_tags($pass1);
  $pass1 = htmlspecialchars($pass1);

  $usr = trim($_POST['usr']);
  $usr = strip_tags($usr);
  $usr = htmlspecialchars($usr);

  if(strlen($pass) < 6) {
    $error = true;
    $errMSG = "Password must have atleast 6 characters.";
  }
  else if(strcmp($pass, $pass1)!=0){
    $error = true;
    $errMSG = "Confirm password did not match!";
  }

  $password = hash('sha256', $pass);

  $query = "SELECT username FROM login WHERE username='$usr'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);
    if($count != 0){
      $error = true;
      $errMSG = "Provided username is already in use!";
    }

  if(!$error) {
    $query = "INSERT INTO login(username, password) VALUES('$usr', '$password')";
    $res = mysqli_query($conn,$query);
    if ($res) {
      header("Location: user_login.php");
        unset($password);
        unset($pass1);
        unset($pass);
        unset($usr);
    } 
	else {
      $errMSG = "Something went wrong, try again later...";
    }
  }
}
?>
<html>
<head>
<script src="home.js"></script>
</head>
<body>
  <div>
    <ul>
      <li id="time"></li>
    </ul>
  </div>
  <div>
      <h2> USER ACCOUNT CREATION </h2>
      <form method="post" action="<?php $_SERVER['PHP_SELF']?>">

        <p>USER NAME </p>
        <input type="text" name="usr" placeholder="Enter Username">

        <p >PASSWORD </p>
        <input type="password" name="pass" placeholder="Enter Password">

		    <p >CONFIRM PASSWORD </p>
        <input type="password" name="pass1" placeholder="Enter Password">

        <input type="submit" name="sign" value="CREATE ACCOUNT">

        <?php if(isset($errMSG)) {?>
          <span style="color:red;"><?php echo $errMSG; ?></span><br><br>
        <?php } ?>

      </form>
</body>
</html>
