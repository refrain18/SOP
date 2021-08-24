<?php
   if(!defined('INDEX')) die("");
   
   // Halaman yang dapat diakses
   $halamanArr = array(
      "sop","rekap_harian","rekap_bulanan",
      "sop_tambah","sop_timer","sop_insert","sop_lihat","sop_edit","sop_update","sop_hapus","sop_rundown",
      "rh_cetak","rh_detail_pertanggal", "rh_detail_perorangan","rh_cetak_detail","rb_cetak",
      "rb_detail","rb_cetak_detail"
   );

   if ($level != 'owner') {
      // Halaman yang bisa di akses user selain Owner
      $halamanArr = array(
         "sop"
      );
   }

   // Halaman yang sedang di maintenance
   $maintenanceArr = array(
      "rekap_bulanan", "sop_rundown","sop_lihat", 
      "rh_cetak", "rh_cetak_detail", "rb_cetak", 
      "rb_detail", "rb_cetak_detail"
   );

   if(isset($_GET['hal']) && !empty($_GET['hal'])) $hal = $_GET['hal'];
   else $hal = "sop";

   foreach($halamanArr as $h){
      if ($h == $hal) {
         foreach($maintenanceArr as $m) {
            if ($h == $m) {
               include "maintenance.php";
               break 2;
            }
         }
         include "konten/$h.php";
         break;
      } 
   }
?>
