<!DOCTYPE html>

<?php
  session_start();
  include_once 'dbconnect.php';

  if(!isset($_SESSION['passkeepsession']) ){
    header("location: user_login.php");
    exit;
  }
  else{
    $usrid = $_SESSION['passkeepsession'];
  }

  $error = false;
  if (isset($_POST['save'])) {

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    $id = trim($_POST['usrid']);
    $id = strip_tags($id);
    $id = htmlspecialchars($id);

    $website = trim($_POST['website']);
    $website = strip_tags($website);
    $website = htmlspecialchars($website);

    function encrypt($plaintext, $key){
      $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
      $iv = openssl_random_pseudo_bytes($ivlen);
      $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
      $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
      $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
      return $ciphertext;
    }

    $key = "abcdefghijklmnop"; // openssl_random_pseudo_bytes(16);
    $password = encrypt($pass, $key);

    if(!$error) {
      $query = "INSERT INTO details(Username, website, id, password) VALUES('$usrid', '$website', '$id', '$password')";
      $res = mysqli_query($conn, $query);
      if($res) {
        unset($password);
        unset($pass);
        unset($website);
        unset($id);
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
  	<title>user_desktop</title>
  </head>
  <body>
  	<nav>
  <div>
    <ul>
      <li id="time"></li>
    </ul>
  </div>
  <div>
      <h2> USER LOGIN </h2>
      <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">

        <p>WEBSITE </p>
        <input type="text" name="website" placeholder="Enter Website">
  
        <p>USERNAME </p>
        <input type="text" name="usrid" placeholder="Enter Username">

        <p>PASSWORD </p>
        <input type="password" name="pass" placeholder="Enter Password">

        <input type="submit" name="save" value="Save">

	      <?php if(isset($errMSG1)) {?>
          <span style="color:red;"><?php echo $errMSG1; ?></span><br><br>
        <?php } ?>
      </form>
    </div>
  </body>
</html>
