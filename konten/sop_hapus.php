<?php
   if(!defined('INDEX')) die("");

   $id = isset($_GET['q']) && !empty($_GET['q']) ? $_GET['q'] : false;

   if (!$id) {
      echo "<meta http-equiv='refresh' content='1; url=?hal=rekap_harian'>";
   }

   $execQuery = mysqli_query($con, "DELETE FROM sop WHERE id_sop = '$id'");

   if($execQuery){
      echo "Data berhasil dihapus!";
      echo "<meta http-equiv='refresh' content='1; url=?hal=sop'>";
   }else{
      echo "Tidak dapat menghapus data!<br>";
      echo mysqli_error($con);
   }