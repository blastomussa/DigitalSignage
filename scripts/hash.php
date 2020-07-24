<?php
  // diplays hash value of user and password combo for test or admin hash gen
  $username = "user";
  $password = "password";
  $val = $username . $password;
  $result = hash("sha256", $val);
  echo $result;
?>
