<?php session_start(); ?>
<?php
require_once('scripts/authenticate.php');
?>
<?php
  if( $_SERVER['REQUEST_METHOD']=='POST' ){ // write new marquee text
      $filename=__DIR__ . "//data//marquee.txt";
      file_put_contents( $filename, implode( PHP_EOL,$_POST ) . PHP_EOL);
      $message = "Marquee updated sucessfully.";
      $_SESSION['message'] = $message;
  }
?>
<!doctype html>
<html>
    <head>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <link rel="stylesheet" type="text/css" href="style/portal.css">
      <title>SICS Announcement Portal</title>
    </head>
    <body>
      <div class="box">
        <h1>SICS Announcement Portal</h1>
        <form method="post">
            <input type="text" class="textClass" id="textInput" value="Enter new marquee announcements here ..... this will overwrite all old announcements ....." name="fileWrite"/>
            <div class="buttons">
              <input type="Submit" value="submit" class="buttonClass"/>
              <input class="buttonClass" type="button" value="Preview" onclick="preview()"/>
            </div>
        </form>
        <div style="display:flex;justify-content:space-between;">
          <?php
            if (isset($_SESSION['message']) && $_SESSION['message'])
            {
              printf('<p>%s</p>', $_SESSION['message']);
              unset($_SESSION['message']);
            }
          ?>
          <p></p>
          <form class="add" action="adduser.php">
            <input class="addButton" type="submit" value="Add User"/>
          </form>
        </div>
      </div>
      <div class="marquee">
  	     <b id="MarqueeText"></b>
      </div>
      <div class="slidediv">
        <div class="slideUpload">
          <div class="slideCenter">

            <form method="POST" action="scripts/upload.php" enctype="multipart/form-data">
              <div>
                <span>Upload a new slideshow image(jpg, jpeg, png only)</span>
                <input type="file" name="uploadedFile" />
              </div>

              <input class="buttonClass" type="submit" name="uploadBtn" value="Upload" />
            </form>
            <form method="post" action="scripts/delete.php">
              <input type="submit" name="deleteBtn" value="Delete All Slides" class="buttonClass"/>
            </form>
          </div>
        </div>
        <div class="slideshow">
          <?php include 'scripts/slideshow.php';?>
        </div>
      </div>
      <script type = "text/javascript">
        var slideIndex = 0;
        showSlides();  // start recursive showSlides call

        function showSlides() {
          var i;
          var slides = document.getElementsByClassName("mySlides");
          for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
          }
          slideIndex++;
          if (slideIndex > slides.length) {slideIndex = 1}

          slides[slideIndex-1].style.display = "inline-block";
          setTimeout(showSlides, 1000); // Change image every 2 seconds
        }

        function preview(){
          data=document.getElementById('textInput').value;
          document.getElementById("MarqueeText").textContent=data;
        }
     </script>
    </body>
</html>
