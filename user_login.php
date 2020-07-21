<?php
  session_start();
  include_once 'dbconnect.php';

  $error = false;

  if(isset($_POST['log'])) {
    
    $error = false;

    $usrid = trim($_POST['usrid']);
    $usrid = strip_tags($usrid);
    $usrid = htmlspecialchars($usrid);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);


    if(empty($pass)){
      $error = true;
      $errMSG1 = "Please enter your password.";
    }
    else{
      $pass = hash('sha256', $pass); 
    }

    if(empty($usrid)){
      $error = true;
      $errMSG1 = "Please enter your user id address.";
    } 
    
    if (!$error) {
      $res=mysqli_query($conn,"SELECT Username, password FROM login WHERE username = '$usrid'");
      $row=mysqli_fetch_array($res);
      $count = mysqli_num_rows($res); 

      if( $count == 1 && $row['password'] == $pass) {
        $_SESSION['passkeepsession'] = $row['Username'];
        header("Location: user_desktop.php");
      } else {
        $errMSG1 = "Incorrect Credentials, Try again...";
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
      <h2> USER LOGIN </h2>
      <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">

        <p >USERNAME </p>
        <input type="text" name="usrid" placeholder="Enter Username">

        <p >PASSWORD </p>
        <input type="password" name="pass" placeholder="Enter Password">

        <input type="submit" name="log" value="Sign In">

	      <?php if(isset($errMSG1)) {?>
          <span style="color:red;"><?php echo $errMSG1; ?></span><br><br>
        <?php } ?>
      </form>
    </div>
</body>
</html>
