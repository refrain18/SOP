<?php
  if(!defined('INDEX')) die("");

  $id = isset($_POST['id_sop']) && !empty($_POST['id_sop']) ? $_POST['id_sop'] : false;

  if (!$id) {
    echo "<meta http-equiv='refresh' content='1; url=?hal=rekap_harian'>";
  }

  $id_pegawai = $_POST['pegawai_id'];
  $id_jenis_pelayanan = $_POST['jp_id'];
  $tgl = date('Y-m-d', strtotime($_POST['tgl_sop']));

  if(!empty($_FILES["fp"]["name"])){
    $nama_img_pegawai = $_FILES["fp"]["name"];
    $tipefile = $_FILES["fp"]["type"];
    $ukuranfile = $_FILES["fp"]["size"];
    if($tipefile != "image/jpeg" and $tipefile != "image/jpg" and $tipefile != "image/png"){
        header("location: ?hal=sop_edit&q=$id&notif=tipefile");
        die();
    }elseif ($ukuranfile >= 3000000) {
        header("location: ?hal=sop_edit&q=$id&notif=ukuranfile");
        die();
    }else{
        move_uploaded_file($_FILES["fp"]["tmp_name"], "gambar/foto_pegawai/".$nama_img_pegawai);
    }
  }

  if(!empty($_FILES["fs"]["name"])){
    $nama_img_struk = $_FILES["fs"]["name"];
    $tipefile = $_FILES["fs"]["type"];
    $ukuranfile = $_FILES["fs"]["size"];
    if($tipefile != "image/jpeg" and $tipefile != "image/jpg" and $tipefile != "image/png"){
        header("location: ?hal=sop_edit&q=$id&notif=tipefilec");
        die();
    }elseif ($ukuranfile >= 3000000) {
        header("location: ?hal=sop_edit&q=$id&notif=ukuranfilec");
        die();
    }else{
        move_uploaded_file($_FILES["fs"]["tmp_name"], "gambar/foto_customer/".$nama_img_struk);
    }
  }

  $query = "UPDATE sop SET 
    pegawai_id = '$id_pegawai', 
    jp_id = '$id_jenis_pelayanan', 
    tanggal = '$tgl', 
    foto_pegawai = '$nama_img_pegawai', 
    foto_customer = '$nama_img_struk' 
    WHERE id_sop = '$id'
  ";
  $execQuery = mysqli_query($con, $query);

  if($execQuery){
    echo "Data berhasil diperbaharui!";
    echo "<meta http-equiv='refresh' content='1; url=?hal=sop'>";
  }else{
    echo "Tidak dapat memperbaharui data!<br>";
    echo "Query Message: ".mysqli_error($con);
  }
?>