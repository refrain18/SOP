<?php
   if(!defined('INDEX')) die("");
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
<h2 class="judul">Tambah SOP Salon Mumtaza</h2>
<form name="myForm" id="meForm" onsubmit="return confirm('Waktu akan dijalankan. Apa anda yakin untuk memulai?');"  method="post" action="?hal=sop_timer" enctype="multipart/form-data">

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
    <label for="nama_pegawai">Nama Pegawai</label>   
    <div class="input">
      <select name="pegawai_id">
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
            if($jp_id == $row['jp_id']) {
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
      <label for="foto_customer">Foto Bukti Customer</label>   
      <div class="input"><input type="file" id="fc" name="fc" required></div> 
  </div>

  <div class="form-group">
      <input type="submit" value="Start" class="tombol start">
  </div>
</form>

<form name="myForm2">
  <input type="email" name="emailku"><br>
  <input type="file" name="fileku">
</form>

<p id="note">test</p>

<img src="#" alt="" id="imgPreview">