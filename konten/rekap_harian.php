<?php
   if(!defined('INDEX')) die("");
?>

<h2 class="judul">Rekap SOP Harian Salon Mumtaza</h2>
<br>
<div>
<form action="" method="GET">
   <input type="hidden" name="hal" value="rekap_harian" readonly>
   <input class="date_seach" type="date" name="filter_tgl">
   <input class="t_search" type="submit" value="Search">
</form>
<!-- <a class="cetak_rh" href="?hal=rh_cetak">Cetak</a> -->
</div>
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
         <th>Aksi</th>
      </tr>
   </thead>
   <tbody>
<?php
   // Set Time Zone    
   ini_set('date.timezone', 'Asia/Jakarta');

   $query = "SELECT 
      a.tanggal, COUNT(id_sop) as total_sop, 
      COUNT(id_sop) as total_cus, 
      (SELECT COUNT(hasil_rundown) FROM sop b WHERE b.tanggal = a.tanggal AND b.hasil_rundown = 'Terpenuhi') as total_completed, 
      (SELECT COUNT(hasil_rundown) FROM sop c WHERE c.tanggal = a.tanggal AND c.hasil_rundown != 'Terpenuhi') as total_incompleted 
      FROM sop a GROUP BY a.tanggal;
   ";
   $execQuery = mysqli_query($con, $query);
   $no = 0;
   while($resQuery = mysqli_fetch_assoc($execQuery)) :
?>
   <tr>
      <td><?php echo ++$no; ?></td>
      <td><?php echo date("D/d-m-Y", strtotime($resQuery['tanggal'])); ?></td>
      <td><?php echo $resQuery['total_sop']; ?></td>
      <td><?php echo $resQuery['total_cus']; ?></td>
      <td><?php echo $resQuery['total_completed']; ?></td>
      <td><?php echo $resQuery['total_incompleted']; ?></td>
      <td>
         <a class="tombol_detail" href="?hal=rh_detail_pertanggal&filter=<?php echo $resQuery['tanggal']; ?>"> Detail </a>
      </td>
   </tr>
<?php endwhile; ?>
   </tbody>
</table>