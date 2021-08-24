<?php
	include "../lib/config.php";

	// Menerima Request Data
	$created_at = isset($_POST['time_stamp']) && !empty($_POST['time_stamp']) ? $_POST['time_stamp'] : false;
	$id_user_by_logged = isset($_POST['id_user']) && !empty($_POST['id_user']) ? $_POST['id_user'] : false;
	$id_user_by_modal = isset($_POST['modal_user_id']) && !empty($_POST['modal_user_id']) ? $_POST['modal_user_id'] : false;
	$id_jps = isset($_POST['pilihan_jenis_perawatan']) && !empty($_POST['pilihan_jenis_perawatan']) ? $_POST['pilihan_jenis_perawatan'] : false;
	$foto_pg = isset($_FILES['foto_pegawai']) && !empty($_FILES['foto_pegawai']) ? $_FILES['foto_pegawai'] : false;
	$foto_struk = isset($_FILES['foto_bukti_struk']) && !empty($_FILES['foto_bukti_struk']) ? $_FILES['foto_bukti_struk'] : false;
	$sop_time_result = isset($_POST['sop_time_result']) && !empty($_POST['sop_time_result']) ? $_POST['sop_time_result'] : false;
	$ket = isset($_POST['keterangan']) || !empty($_POST['keterangan']) ? $_POST['keterangan'] : '-';

	// Default Response
	$status = false;
	$msg = 'Error pada server tidak diketahui!';

	// Error Handling - Cek Request
	if (!$created_at || !$id_user_by_logged || !$id_user_by_modal || !$id_jps || !$foto_pg || !$foto_struk || !$sop_time_result) {
		$status = true;
		$msg = 'Request tidak valid!';
	}

	if (!$status) {
		// Konversi string ke format waktu
		$sop_time_result = date("H:i:s", strtotime($sop_time_result));

		// Konversi array checkbox ke string
		$jp_ids_string = implode(",", $id_jps);

		$query = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(waktu))) as total_waktu_target, SUM(komisi) as total_komisi FROM jenis_perawatan WHERE jp_id IN ($jp_ids_string)";

		$execQuery = mysqli_query($con, $query);
		$queryResult = mysqli_fetch_assoc($execQuery);

		$targetDurasi = date("H:i:s", strtotime($queryResult['total_waktu_target']));

		if ($sop_time_result < $targetDurasi) {
			$hasil_run_down = "Tidak terpenuhi";
			$komisi = 0;
		} elseif ($sop_time_result >= $targetDurasi) {
			$hasil_run_down = "Terpenuhi";
			$komisi = $queryResult['total_komisi'];
		}

		// Ekstraksi array File
		$nama_foto_pegawai = $foto_pg["name"];
		$nama_foto_struk = $foto_struk["name"];
		// move_uploaded_file($foto_pg["tmp_name"], "gambar/foto_customer/".$nama_foto_pegawai);

		for ($i=0; $i < count($id_jps) ; $i++) { 
			$execQuery = mysqli_query($con, "INSERT INTO sop SET 
				pegawai_id = '$id_user_by_modal',
				jp_id = '$id_jps[$i]',
				tanggal = '$created_at',
				foto_pegawai = '$nama_foto_pegawai',
				foto_struk = '$nama_foto_struk',
				waktu = '$sop_time_result',
				hasil_rundown = '$hasil_run_down',
				keterangan = '$ket',
				komisi = '$komisi'
			");
		}

		$status = true;
		if($execQuery){
			$msg = "Data SOP telah disimpan!";
		}else{
			$msg = "Query Gagal! ".mysqli_error($con);
		}
	}

	echo json_encode(
		array(
			'status' => $status,
			'message' => $msg,
			'debug' => array()
		)
	);