<?php
   session_start();
   include "lib/config.php";

   $username = $_POST['username'];
   $password = md5($_POST['password']);

   $query = mysqli_query($con, "SELECT user.*, pegawai.pegawai_id 
      FROM user LEFT JOIN pegawai ON user.user_id = pegawai.user_id 
      WHERE (user.username='$username' AND user.password='$password') AND (user.level != 'sdm' AND user.level != 'kasir') AND user.status = 'on'"
   );
   $data = mysqli_fetch_array($query);
   $jml = mysqli_num_rows($query);

   if($jml > 0){
      $_SESSION['sop_sessionArr'] = array(
         'id_user' => $data['user_id'],
         'username' => $data['username'],
         'password' => $data['password'],
         'level' => $data['level']
      );
      
      header('location: index.php');
   }else{
      echo "<p align='center'>Login Gagal</p>";
      echo "<meta http-equiv='refresh' content='2; url=login.php'>";
   }
?>