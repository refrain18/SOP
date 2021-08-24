<?php
  if(!defined('INDEX')) die("");

  $id = isset($_GET['q']) && !empty($_GET['q']) ? $_GET['q'] : false;

  if(!$id) {
    echo "<meta http-equiv='refresh' content='1; url=?hal=rekap_harian'>";
  }

  $query = "SELECT pegawai_id, jp_id, foto_pegawai, foto_struk, tanggal FROM sop WHERE id_sop = '$id'";
  $execQuery = mysqli_query($con, $query) OR die("Terjadi kesalahan pada server: ".mysqli_error($con));
  
  if (mysqli_num_rows($execQuery) <= 0) {
    echo "<meta http-equiv='refresh' content='1; url=?hal=rekap_harian'>";
  }
  $resQuery = mysqli_fetch_assoc($execQuery);

  $pegawaiId = $resQuery['pegawai_id'];
  $jenisPelayananId = $resQuery['jp_id'];
  $fotoPegawai = $resQuery['foto_pegawai'];
  $fotoStruk = $resQuery['foto_struk'];
  $tgl = $resQuery['tanggal'];
?>
<!-- <script>
function validateForm() {
  var validasiHuruf = /^[a-zA-Z ]+$/;  
  var x = document.forms["myForm"]["nama"].value;
  var y = document.forms["myForm"]["tmpt_lahir"].value;
  var z = document.forms["myForm"]["no_hp"].value;
  if (x.value.match(validasiHuruf)) {
    
  }else{
    alert("NAMA HARUS HURUF !");
    return false;
  }
  if (y !== (/^[a-zA-Z ]+$/)) {
    alert("TEMPAT LAHIR HARUS HURUF !");
    return false;
  }
  if (z !== (/^[0-9]+$/)) {
    alert("NO.HP HARUS ANGKA !");
    return false;
  }
}
</script> -->
<h2 class="judul">Edit SOP Salon Mumtaza</h2>
<form name="myForm" onsubmit="return confirm('Simpan Perubahan?');"  method="post" action="?hal=sop_update" enctype="multipart/form-data">

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

  <input type="hidden" name="id_sop" value="<?php echo $id;?>">

  <div class="form-group">
    <label for="nama_pegawai">Nama Pegawai</label>   
    <div class="input">
      <select name="pegawai_id">
        <?php
          $query = mysqli_query($con, "SELECT pegawai_id, nama FROM pegawai ORDER BY pegawai_id ASC");
          while($row=mysqli_fetch_assoc($query)){
            if($pegawaiId == $row['pegawai_id']) {
              echo "<option value='$row[pegawai_id]' selected='true'>$row[nama]</option>";
            }else{
              echo "<option value='$row[pegawai_id]'>$row[nama]</option>";
            }
          }
        ?>
      </select>
    </div> 
  </div>
  <div class="form-group">
    <label for="nama_perawatan">Jenis Perawatan</label>       
    <div class="input">
      <select name="jp_id">
        <?php
          $query = mysqli_query($con, "SELECT jp_id, nama_perawatan FROM jenis_perawatan ORDER BY jp_id ASC");
          while($row=mysqli_fetch_assoc($query)){
            if($jenisPelayananId == $row['jp_id']) {
              echo "<option value='$row[jp_id]' selected='true'>$row[nama_perawatan]</option>";
            }else{
              echo "<option value='$row[jp_id]'>$row[nama_perawatan]</option>";
            }
          }
        ?>
      </select>
    </div> 
  </div>   

  <div class="form-group">
    <label for="foto_pegawai">Foto Pegawai</label>   
    <div class="input"><input type="file" id="fp" name="fp" required></div> 
  </div>
  <div class="form-group">
    <label for="fs">Foto Bukti Struk</label>   
    <div class="input"><input type="file" id="fs" name="fs" required></div> 
  </div>
  <div class="form-group">
    <label for="tanggal">Tanggal</label>   
    <div class="input"><input type="date" id="tanggal" name="tgl_sop" value="<?php echo date('Y-m-d', strtotime($tgl));?>" required></div> 
  </div>

  <div class="form-group">
    <a class="tombol hapus" href="?hal=rh_detail_perorangan&q=<?= "$pegawaiId,$tgl"; ?>">Kembali</a>
    <input type="submit" name="btn_sop_update" value="Simpan" class="tombol edit">
  </div>
</form>