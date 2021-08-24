<?php
   if(!defined('INDEX')) die("");

   $query = mysqli_query($con, "SELECT sop.*, pegawai.nama, jenis_perawatan.nama_perawatan FROM sop JOIN pegawai ON  
                                sop.pegawai_id = pegawai.pegawai_id JOIN jenis_perawatan ON sop.jp_id = jenis_perawatan.jp_id 
                                ORDER BY id_sop DESC WHERE id_sop='$_GET[id_sop]'");

   $data = mysqli_fetch_array($query);

   $foto_pegawai = $data['foto_pegawai'];
   $foto_customer = $data['foto_customer'];

   $gambar_p = "<img src='gambar/foto_pegawai/$foto_pegawai' style='width: 200px; vertical-align: middle;'/>";
   $gambar_c = "<img src='gambar/foto_customer/$foto_customer' style='width: 200px; vertical-align: middle;'/>";
?>

<h2 class="judul">Tambah SOP Salon Mumtaza</h2>
<form name="myForm" onsubmit="return validateForm()" method="post" action="?hal=sop" enctype="multipart/form-data">

<?php
      
      $notif = isset($_GET['notif']) ? $_GET['notif'] : false;

      if($notif == 'tipefile') {
         echo "<div class='notif' id='notif'>Tipe file tidak didukung!</div>";
      }elseif($notif == 'ukuranfile') {
         echo "<div class='notif' id='notif'>Ukuran file tidak boleh lebih dari 3MB</div>";
      }elseif($notif == 'tipefilec'){
        echo "<div class='notif' id='notif'>Tipe file tidak didukung!</div>";
      }elseif ($notif == 'ukuranfilec') {
        echo "<div class='notif' id='notif'>Ukuran file tidak boleh lebih dari 3MB</div>";
      }

?>
<div class="form-group">
    <label for="tanggal">Tanggal</label>   
    <div class="input"><input type="date" id="tanggal" name="tanggal" value="<?= $data['tanggal'] ?>" onkeyup="validasi()"></div> 
</div>

<div class="form-group">
      <label for="nama_pegawai">Nama Pegawai</label>   
      <div class="input"><select name="pegawai_id">
                <?php
                    $query = mysqli_query($con, "SELECT pegawai_id, nama FROM pegawai ORDER BY pegawai_id ASC");
                    while($row=mysqli_fetch_assoc($query)){
                        if($pegawai_id == $row['pegawai_id']) {
                            echo "<option value='$row[pegawai_id]' selected='true'>$row[nama]</option>";
                        }else{
                            echo "<option value='$row[pegawai_id]'>$row[nama]</option>";
                        }
                    }
                ?>
            </select></div> 
   </div>
   <div class="form-group">
      <label for="nama_perawatan">Jenis Perawatan</label>       
        <div class="input"><select name="jp_id">
                            <?php
                                $query = mysqli_query($con, "SELECT jp_id, nama_perawatan FROM jenis_perawatan ORDER BY jp_id ASC");
                                while($row=mysqli_fetch_assoc($query)){
                                    if($jp_id == $row['jp_id']) {
                                        echo "<option value='$row[jp_id]' selected='true'>$row[nama_perawatan]</option>";
                                    }else{
                                        echo "<option value='$row[jp_id]'>$row[nama_perawatan]</option>";
                                    }
                                }
                            ?>
                            </select></div> 
    </div>     

   <div class="form-group">
      <label for="foto_pegawai">Foto Pegawai</label>   
      <div class="input"><input type="file" id="fp" name="fp" value="<?= $foto_pegawai ?>" onkeyup="validasi()"> <?= $gambar_p ?> </div> 
   </div>
   <div class="form-group">
      <label for="foto_customer">Foto Bukti Customer</label>   
      <div class="input"><input type="file" id="fc" name="fc" value="<?= $foto_customer ?>" onkeyup="validasi()"> <?= $gambar_c ?> </div> 
   </div>
   <div class="form-group">
      <label for="waktu_perawatan">Waktu Perawatan</label>   
      <div class="input"><input type="time" id="waktu" name="waktu" value="<?= $data['waktu'] ?>" onkeyup="validasi()"></div> 
   </div>
   <div class="form-group">
      <label for="hasil_rundown">Hasil Rundown</label>   
      <div class="input"><input type="text" id="hasil_rundown" name="hasil_rundown" value="<?= $data['hasil_rundown'] ?>" onkeyup="validasi()"></div> 
   </div>
   <div class="form-group">
      <label for="keterangan">Keterangan</label>   
      <div class="input"><input type="text" id="keterangan" name="keterangan" value="<?= $data['keterangan'] ?>" onkeyup="validasi()"></div> 
   </div>
   <div class="form-group">
      <input type="submit" value="Kembali" class="tombol edit>
</form>