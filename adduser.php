<?php session_start(); ?>
<?php
  // set variables
  $user = $_SERVER['PHP_AUTH_USER'];
  $pass = $_SERVER['PHP_AUTH_PW'];

  // calculate hash
  $val = $user . $pass;
  $result = hash("sha256", $val);

  // open hash text file
  // this might need to be changed for linux
  $file = "data/admin.txt";
  $doc = file_get_contents($file);
  $line = explode("\n",$doc);

  // search hash file for authorized user/password combination
  $admin = false;
  foreach($line as $newline){
    $check = strncmp($newline, $result,64);
    if($check == 0){
      $admin = true;
    }
  }
  if (!$admin) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    die ("Not authorized");
  }
?>
<?php
  if( $_SERVER['REQUEST_METHOD']=='POST' ){

    $username = $_POST["name"];
    $password = $_POST["password"];

    // this all needs to be changed to grab post form variables
    $val = $username . $password;
    $result = hash("sha256", $val);

    // change to append text file
    $filename=__DIR__ . "//data//user.txt";
    file_put_contents( $filename, $result . PHP_EOL, FILE_APPEND);

    $message = "User added sucessfully.";
    $_SESSION['message'] = $message;
    header("Location: portal.php");
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style/adduser.css">
    <title>Portal User Management</title>
  </head>
  <body>
    <div class="box">
      <h1>Add Announcment Portal User</h1>
      <form method="post">
        Username: <input class="inputClass" type="text" name="name"><br>
        Password: <input class="inputClass" type="text" name="password"><br>
        <br>
        <input class="submitButton" type="submit">
      </form>
    </div>
  </body>
</html>
