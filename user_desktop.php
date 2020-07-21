<!DOCTYPE html>

<?php
  ini_set('memory_limit', '-1');
  session_start();
  include_once 'dbconnect.php';

  if(!isset($_SESSION['passkeepsession']) ){
    header("location: user_login.php");
    exit;
  }
  else{
    $usrid = $_SESSION['passkeepsession'];
  }

  $res1 = mysqli_query($conn, "SELECT website, id, password FROM details WHERE Username = '$usrid'");
  $row1 = mysqli_fetch_array($res1);
  $count = mysqli_num_rows($res1);

  function decrypt($ciphertext, $key){
    $c = base64_decode($ciphertext);
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len=32);
    $ciphertext_raw = substr($c, $ivlen+$sha2len);
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
    if(hash_equals($hmac, $calcmac)){
      return $original_plaintext;
    }
    else{
      return "fail!";
    }
  }
  $key = "abcdefghijklmnop";
  $ret = array();
  while($row = $row1){
    $temp = array($row[0], $row[1], decrypt($row[2], $key));
    array_push($ret, $temp);
  }
  // $ret is our result!
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
    <table>
      <tr>
          <th>Product Id</th>
          <th>Ammount</th>
      </tr>

      <?php
      foreach ($ret as $subAray)
      {
          ?>
          <tr>
              <td><?php echo $subAray[0]; ?></td>
              <td><?php echo $subAray[1]; ?></td>
              <td><?php echo $subAray[2]; ?></td>
          </tr>
          <?php
      }
      ?>
    </table>
  </div>
  </body>
</html>
