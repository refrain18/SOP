<?php
  $host = "103.253.212.12";
  $user = "mumq3842_dena";
  $pass = "bismillahsuksesjaya";
  $db   = "mumq3842_cadangan_sop";

  $con = mysqli_connect($host, $user, $pass, $db);
  if (mysqli_connect_errno()){
    echo "Koneksi gagal: " . mysqli_connect_error();
  }
?>