<?php
   if(!defined('INDEX')) die("");
?>

<h2 class="judul">Detail Rekap SOP Bulanan Salon Mumtaza</h2>
<br>
<div>
<form action="">   
<label class="label_bulan_rb" for="">Bulan</label>
<select class="select_bulan_rb" name="bulan" id="bulan">
    <option value="januari">Januari</option>
    <option value="februari">Februari</option>
    <option value="maret">Maret</option>
    <option value="april">April</option>
    <option value="mei">Mei</option>
    <option value="juni">Juni</option>
    <option value="juli">Juli</option>
    <option value="agustus">Agustus</option>
    <option value="september">September</option>
    <option value="oktober">Oktober</option>
    <option value="november">November</option>
    <option value="desember">Desember</option>
</select>

<label class="label_tahun_rbd" for="">Tahun</label>
<select class="select_tahun_rbd" name="tahun" id="tahun">
    <option value="2020">2020</option>
    <option value="2021">2021</option>
</select>
</form>
</div>
<a class="cetak" href="?hal=rb_cetak_detail">Cetak</a>
<br>
<br>
<br>
<!-- <a class="cetak" href="?hal=cetak_pg">Cetak</a> -->
</br>
<table class="table">
   <thead>
      <tr>
         <th>No</th>
         <th>Hari/Tanggal</th>
         <th>Total SOP Harian</th>
         <th>Total Customer</th>
         <th>Rundown Complete</th>
         <th>Rundown Incomplete</th>
      </tr>
   </thead>
   <tbody>
<?php
//    $query = mysqli_query($con, "SELECT produk_salon.*, stok_masuk.harga FROM produk_salon JOIN stok_masuk ON produk_salon.produk_id = stok_masuk.produk_id ORDER BY produk_id ASC");
//    $no = 0;
//    while($data = mysqli_fetch_array($query)){
//       $no++;


?>
      <tr>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
         <td></td>
     </tr>
<?php
   //}
?>
   </tbody>
</table>