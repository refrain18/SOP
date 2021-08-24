<?php
   if(!defined('INDEX')) die("");
?>

<h2 class="judul">Rekap SOP Bulanan Salon Mumtaza</h2>
<br>
<div>
<label class="label_tahun_rb" for="">Tahun</label>
<select class="select_tahun_rb1" name="tahun" id="tahun">
    <option value="2020">2020</option>
    <option value="2021">2021</option>
</select>
<a class="cetak_rh" href="?hal=rb_cetak">Cetak</a>
</div>
<!-- <a class="cetak" href="?hal=cetak_pg">Cetak</a> -->
</br>
</br>
</br>
<table class="table">
   <thead>
      <tr>
         <th>No</th>
         <th>Bulan</th>
         <th>Total SOP Bulanan</th>
         <th>Total Customer</th>
         <th>Rundown Complete</th>
         <th>Rundown Incomplete</th>
         <th>Aksi</th>
      </tr>
   </thead>
   <tbody>
<?php
//    $query = mysqli_query($con, "SELECT absen.*, pegawai.nama FROM absen JOIN pegawai ON absen.pegawai_id = pegawai.pegawai_id ORDER BY pegawai_id ASC");
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
         <td>
            <a class="tombol_detail" href="?hal=rb_detail&=<?= $data[''] ?>"> Detail </a>
         </td>
     </tr>
<?php
   //}
?>
   </tbody>
</table>