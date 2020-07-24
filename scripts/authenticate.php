<?php
  // set variables
  $user = $_SERVER['PHP_AUTH_USER'];
  $pass = $_SERVER['PHP_AUTH_PW'];

  // calculate hash
  $val = $user . $pass;
  $result = hash("sha256", $val);

  // open hash text file
  // this might need to be changed for linux
  $file = "data/user.txt";
  $doc = file_get_contents($file);
  $line = explode("\n",$doc);

  // search user hash file for authorized user/password combination
  $auth = false;
  foreach($line as $newline){
    $check = strncmp($newline, $result,64);
    if($check == 0){
      $auth = true;
    }
  }

  $file = "data/admin.txt";
  $doc = file_get_contents($file);
  $line = explode("\n",$doc);

  // search admin hash file for authorized user/password combination
  foreach($line as $newline){
    $check = strncmp($newline, $result,64);
    if($check == 0){
      $auth = true;
    }
  }

  // reload page
  if (!$auth) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    die ("Not authorized");
  }
?>
