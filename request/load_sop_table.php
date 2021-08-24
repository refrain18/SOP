<?php
	include "../lib/config.php";
  
	$id_user = isset($_GET['id_user']) && !empty($_GET['id_user']) ? $_GET['id_user'] : false;
  
  // Set Time Zone    
  ini_set('date.timezone', 'Asia/Jakarta');
  $current_timestamp = date("Y-m-d");

  // Error Handling - Cek Request
	if (!$id_user) {
		$status = true;
		$msg = 'Request tidak valid!';
	}

  // Default Response
	$status = false;
	$msg = 'Error pada server tidak diketahui!';
  $html_val = '';

  if (!$status) {
    $execQuery_getSop = mysqli_query($con, "SELECT sop.*, pegawai.nama, jenis_perawatan.nama_perawatan, sop.komisi 
      FROM sop JOIN pegawai ON sop.pegawai_id = pegawai.pegawai_id JOIN jenis_perawatan ON sop.jp_id = jenis_perawatan.jp_id 
      WHERE sop.tanggal = '$current_timestamp' AND sop.pegawai_id = '$id_user' 
      ORDER BY id_sop DESC"
    );

		if($execQuery_getSop){
      $no = 0;
      if (mysqli_num_rows($execQuery_getSop) > 0 ) {
        while ($data = mysqli_fetch_array($execQuery_getSop)) {
          $html_val .= "
          <tr>
          <td>". ++$no ."</td>
          <td>$data[foto_pegawai]</td>
          <td>$data[foto_struk]</td>
          <td>$data[hasil_rundown]</td>
          <td>$data[komisi]</td>
          <td>$data[keterangan]</td>
          </tr>"
          ;
        }
      } else {
        $html_val = '
        <tr>
        <td colspan="6"><center>Belum ada SOP tersimpan pada record hari ini!</center></td>
        </tr>
        ';
      }
      $status = true;
      $msg = "Data Sop telah di load!";
		}else{
      $msg = "Query Gagal! ".mysqli_error($con);
		}
  }

	echo json_encode(
		array(
			'status' => $status,
			'message' => $msg,
      'html' => $html_val
		)
	);

