<?php
session_start();
if (isset($_POST['deleteBtn'])){
  // change from test
  $files = glob('../img/*'); // get all file names
  foreach($files as $file){
    unlink($file); // delete file
  }
  $message ='Slideshow deleted successfully';
}
$_SESSION['message'] = $message;
header("Location: ../portal.php");
