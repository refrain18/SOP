<?php
   session_start();
   if (isset($_SESSION['sop_sessionArr'])) {
      unset($_SESSION['sop_sessionArr']);
      echo "<p align='center'>Anda telah logout!</p>";
      echo "<meta http-equiv='refresh' content='2; url=login.php'>";
      die();
   }
   echo "<meta http-equiv='refresh' content='1; url=index.php'>";