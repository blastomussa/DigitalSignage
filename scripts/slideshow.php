<?php
  foreach (glob("img/*") as $filename) {
    echo "<img class='mySlides fade' src=$filename>";
  }
?>
