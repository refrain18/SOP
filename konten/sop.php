<?php
   if(!defined('INDEX')) die("");
?>
<!-- Modal -->
<div id="modal">
   <h1>Pilih SOP!</h1>
   <form name="sopForm" id="sop-form" onsubmit="return validateSopForm(this);">
      <?php 
         // $notif = isset($_GET['notif']) ? $_GET['notif'] : false;
         // if($notif == 'tipefile') { echo "<div class='notif' id='notif'>Tipe file tidak didukung!</div>"; }
         // elseif($notif == 'ukuranfile') { echo "<div class='notif' id='notif'>Ukuran file tidak boleh lebih dari 3MB</div>"; }
         // elseif($notif == 'tipefilec'){ echo "<div class='notif' id='notif'>Tipe file tidak didukung!</div>"; }
         // elseif ($notif == 'ukuranfilec') { echo "<div class='notif' id='notif'>Ukuran file tidak boleh lebih dari 3MB</div>"; }

         $query = "SELECT jp_id, nama_perawatan FROM jenis_perawatan";
         $execQuery = mysqli_query($con, $query) OR die('Terjadi kesalahan pada server: '.mysqli_error($con));

         // Set Time Zone    
         ini_set('date.timezone', 'Asia/Jakarta');
         $current_timestamp = date("Y-m-d");
      ?>

      <!-- Hidden Input -->
      <input type="hidden" name="time_stamp" value="<?php echo $current_timestamp; ?>">
      <input type="hidden" name="id_user" value="<?php echo $ID_CURRENT_USER; ?>">
      <input type="hidden" id="modal_user_id" name="modal_user_id" value="">

      <div class="form-group">
         <label for="foto_pegawai">Upload Foto Clusterx: </label>
         <div class="input"><input type="file" id="foto_pegawai" name="foto_pegawai" required></div> 
      </div>
      <div class="form-group">
         <label for="pilih_jk">Jenis Perawatan: </label>
         <div 
            class="input-checkbox"
            style="height: 100px; overflow-y: scroll;"
         >
            <?php while($resQueryInLoop = mysqli_fetch_assoc($execQuery)) : ?>
               <span>
                  <input 
                     type="checkbox" class="sop_checkbox" 
                     onclick="timeEstCalc($(this).parent().parent().parent().parent());" 
                     name="pilihan_jenis_perawatan[]" value="<?php echo $resQueryInLoop['jp_id'];?>"
                  >
                  <span><?php echo " $resQueryInLoop[nama_perawatan]"; ?></span>
               </span><br>
               <?php endwhile; ?>
            </div> 
      </div>
      <div class="form-group" id="timeResWrapper">
         <label for="time">Time : </label>   
         <div class="input">
            <input type="text" id="totalSopTimeEst" name="totalSopTimeEst" value="00:00:00" disabled>
         </div> 
      </div>
      <div class="form-group">
         <input type="submit" value="Start" class="tombol start close-button">
      </div>
   </form>
</div>

<h1>Selamat Datang di Standard Operating Procedure</h1>
<h3 class="judul">Anda login sebagai <?= ucfirst($level) ?> </h3>

<?php
   // Penambahan Where
   $where = "";
   if ($level == 'clusterx') {
      $where = "AND user.user_id = '$ID_CURRENT_USER'";
   }
   $query_getUsers = "SELECT pegawai_id, pegawai.nama FROM pegawai JOIN user ON pegawai.user_id = user.user_id WHERE user.level = 'clusterx' AND user.status = 'on' $where";
   // $query_getUsers = "SELECT user_id, username FROM user WHERE level IN ('owner', 'clusterx')";
   $execQuery_getUser1 = mysqli_query($con, $query_getUsers) OR die('Terjadi kesalahan pada server: '.mysqli_error($con));
   $execQuery_getUser2 = mysqli_query($con, $query_getUsers) OR die('Terjadi kesalahan pada server: '.mysqli_error($con));
   //$i=0;
?>
<div data-tabs>
   <?php while($resQuery = mysqli_fetch_assoc($execQuery_getUser1)) : ;?>
      <div><?php echo ucfirst($resQuery['nama']);//$i++; ?></div>
   <?php endwhile; ?>
</div>

<div data-panes>
   <?php
      $idUserPanesArr = array();
   ?>
   <?php while($resQuery = mysqli_fetch_assoc($execQuery_getUser2)) ://for($j=0;$j<$i;$j++) : ;?>
      <?php array_push($idUserPanesArr, $resQuery['pegawai_id']) ;?>
      <div>
         <div class="scrollable-card-content" id="<?php echo "_$resQuery[pegawai_id]";?>">
            <div class="flex-container">
               <div class="flex-item" style="align-self: baseline;">
                  <p>Jenis Perawatan : <span id="jenisPerawatan"></span></p><br>
                  <p id="waktuSop"><span id="durasiSopBerjalan">00:00</span> S/D <span id="targetDurasiSop">00:00</span></p><br>
                  <button id="startSopBtn" class="tombol edit" onclick="modalTrigger(); sendTabIdsToCurrentModal(<?php echo $resQuery['pegawai_id'];?>);" type="button">Start</button>
                  <button id="stopSopBtn" class="tombol hapus" onclick="stopSop(<?php echo $resQuery['pegawai_id'];?>);" type="button" disabled>Stop</button>
               </div>
            </div>
            <table class="table">
               <thead>
                  <tr>
                     <th>No</th>
                     <th>Foto Pegawai</th>
                     <th>Foto Bukti Struk</th>
                     <th>Hasil Rundown</th>
                     <th>Komisi</th>
                     <th>Keterangan</th>
                  </tr>
               </thead>
               <tbody id="sopTable">
                  <!-- <script type="text/javascript">
                     window.onload = function(){
                        loadSopTable(<?php //echo $resQuery['user_id'] ;?>); 
                     };
                  </script> -->
               </tbody>
            </table>
         </div>
      </div>
      
   <?php endwhile;//endfor; ?>
   <?php 

   echo "
      <script type='text/javascript'>
         window.onload = function(){
            loadSopTables([".implode(', ', $idUserPanesArr)."]); 
         };
      </script>
   ";

      // echo "
      //    <script>
      //       window.onload = function(){
      //          loadSopTable($resQuery[user_id]); 
      //       };
      //    </script>
      // ";
      // $execQuery_getSop = mysqli_query($con, "SELECT sop.*, pegawai.nama, jenis_perawatan.nama_perawatan, sop.komisi 
      //    FROM sop JOIN pegawai ON sop.pegawai_id = pegawai.pegawai_id JOIN jenis_perawatan ON sop.jp_id = jenis_perawatan.jp_id 
      //    WHERE sop.tanggal = '$current_timestamp' AND sop.pegawai_id = '$resQuery[user_id]' 
      //    ORDER BY id_sop DESC LIMIT 5");
      // $no = 0;
   ?>
</div>

<script src="js/tabbisCaller.js" defer></script>