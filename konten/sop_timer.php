<?php
  if(!defined('INDEX')) die("");

  // Set Time Zone    
  ini_set('date.timezone', 'Asia/Jakarta');
  $current_timestamp = date("Y-m-d");

  $pegawai_id = $_POST['pegawai_id'];
  $jp_id = $_POST['jp_id'];


  var_dump($_FILES['fc']);
  die();


  if(!empty($_FILES["fp"]["name"])){
    $f_pegawai = $_FILES["fp"]["name"];
    $tipefile = $_FILES["fp"]["type"];
    $ukuranfile = $_FILES["fp"]["size"];
    if($tipefile != "image/jpeg" and $tipefile != "image/jpg" and $tipefile != "image/png"){
      header("location: ?hal=sop_tambah&id_sop=$id_sop&notif=tipefile");
      die();
    }elseif ($ukuranfile >= 3000000) {
      header("location: ?hal=sop_tambah&id_sop=$id_sop&notif=ukuranfile");
      die();
    } else {
      move_uploaded_file($_FILES["fp"]["tmp_name"], "gambar/foto_pegawai/".$f_pegawai);
    }
  }

  if(!empty($_FILES["fc"]["name"])){
    $f_customer = $_FILES["fc"]["name"];
    $tipefile = $_FILES["fc"]["type"];
    $ukuranfile = $_FILES["fc"]["size"];
    if($tipefile != "image/jpeg" and $tipefile != "image/jpg" and $tipefile != "image/png"){
      header("location: ?hal=sop_tambah&id_sop=$id_sop&notif=tipefilec");
      die();
    }elseif ($ukuranfile >= 3000000) {
      header("location: ?hal=sop_tambah&id_sop=$id_sop&notif=ukuranfilec");
      die();
    }else{
      move_uploaded_file($_FILES["fc"]["tmp_name"], "gambar/foto_customer/".$f_customer);
    }
  }

  $_SESSION['sopArr'] = array(
    'id_pegawai' => $pegawai_id,
    'id_jenis_perawatan' => $jp_id,
    'tanggal' => $current_timestamp,
    'foto_pegawai' => $f_pegawai,
    'foto_customer' => $f_customer
  );

  $query = "SELECT nama_perawatan, waktu FROM jenis_perawatan WHERE jp_id = '$jp_id'";
  $execQuery = mysqli_query($con, $query);
  $queryResult = mysqli_fetch_assoc($execQuery);
?>
<center style="margin-top: 150px">
    <h2><?php echo $queryResult['nama_perawatan'];?> dengan durasi <span id="targetDurasiSop"><?php echo $queryResult['waktu'];?></span></h2>
    <h1 id="hasilDurasiSop"></h1>
    <button class="tombol hapus" onclick="stopTimer();">Stop</button><br>
    <p id="end"></p>
</center>
<!-- <script src="js/timerCaller.js" defer></script> -->
<script src="js/sopTimeRequestCaller.js" defer></script>