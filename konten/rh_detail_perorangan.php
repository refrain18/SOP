<?php
   if(!defined('INDEX')) die("");
   // Untuk Filter Detail Laporan Bulanan
   $filter = isset($_GET['q']) && !empty($_GET['q']) ? explode(',', $_GET['q']) : false;

   if (!$filter) {
      echo "<meta http-equiv='refresh' content='1; url=?hal=rekap_harian'>";
   }

   $id = $filter[0];
   $tgl = $filter[1];

   $query = "SELECT 
      pegawai.nama, 
      (SELECT COUNT(sop_b.hasil_rundown) FROM sop sop_b WHERE sop_b.tanggal = sop_a.tanggal AND sop_b.pegawai_id = sop_a.pegawai_id AND sop_b.hasil_rundown = 'Terpenuhi') as completed, 
      (SELECT COUNT(sop_c.hasil_rundown) FROM sop sop_c WHERE sop_c.tanggal = sop_a.tanggal AND sop_c.pegawai_id = sop_a.pegawai_id AND sop_c.hasil_rundown != 'Terpenuhi') as incompleted 
      FROM sop sop_a JOIN pegawai ON sop_a.pegawai_id = pegawai.pegawai_id WHERE sop_a.pegawai_id = '$id' AND sop_a.tanggal = '$tgl' GROUP BY sop_a.tanggal;
   ";
   $execQuery = mysqli_query($con, $query) OR die("Terjadi Kesalahan pada Query: ".mysqli_error($con));
   if (mysqli_num_rows($execQuery) <= 0) {
      echo "<meta http-equiv='refresh' content='1; url=?hal=rekap_harian'>";
   }
   $resQuery = mysqli_fetch_assoc($execQuery);
?>

<h2 class="judul">Detail Rekap SOP Harian Salon Mumtaza</h2>
<div class="label_123">
    <label class="l_haritanggal" for="">Hari/Tanggal : <?php echo $tgl; ?></label>
    <br>
    <label class="l_tsh" for="">Nama : <?php echo $resQuery['nama']; ?></label>
    <label class="l_rc" for="">Rundown Complete : <?php echo $resQuery['completed']; ?></label>
    <label class="l_ri" for="">Rundown Incomplete : <?php echo $resQuery['incompleted']; ?></label>
</div>
<!-- <a class="cetak" href="?hal=rh_cetak_detail">Cetak</a> -->
<br>
<!-- <a class="cetak" href="?hal=cetak_pg">Cetak</a> -->
</br>
<table class="table">
   <thead>
      <tr>
         <th>No</th>
         <th>Jenis Perawatan</th>
         <th>Foto Pegawai</th>
         <th>Foto Struk</th>
         <th>Rundown</th>
         <th>Keterangan</th>
         <?php if($level == 'owner') : ?>
            <th>Aksi</th>
         <?php endif; ?>
      </tr>
   </thead>
   <tbody>
<?php
   $query = "SELECT 
      sop.id_sop, jp.nama_perawatan, sop.foto_pegawai as img_pgw, sop.foto_struk as img_struk, sop.hasil_rundown, sop.keterangan, pegawai.nama
      FROM sop JOIN pegawai ON pegawai.pegawai_id = sop.pegawai_id JOIN jenis_perawatan jp ON jp.jp_id = sop.jp_id 
      WHERE sop.pegawai_id = '$id' AND sop.tanggal = '$tgl';
   ";
   $execQuery = mysqli_query($con, $query) OR die('Kesalahan pada query: '.mysqli_error($con));
   $no = 0;
   while($data = mysqli_fetch_assoc($execQuery)){
   $no++;
?>
      <tr>
         <td><?= $no ?></td>
         <td><?= $data['nama_perawatan'] ?></td>
         <td><?= $data['img_pgw'] ?></td>
         <td><?= $data['img_struk'] ?></td>
         <td><?= $data['hasil_rundown'] ?></td>
         <td><?= $data['keterangan'] ?></td>
         <?php if($level == 'owner') : ?>
            <td>
               <a class="tombol edit" href="?hal=sop_edit&q=<?= $data['id_sop'] ?>"> Edit </a>
               <a class="tombol hapus" href="?hal=sop_hapus&q=<?= $data['id_sop'] ?>"> Delete </a>
            </td>
         <?php endif; ?>
     </tr>
<?php
   }
?>
   </tbody>
</table>
<a class="tombol edit" style="margin-top:30px;float:right;" href="?hal=rh_detail_pertanggal&filter=<?php echo $tgl; ?>">Kembali</a>
