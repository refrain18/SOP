<?php

include "../lib/config.php";

$jp_ids_str = isset($_POST['sopArr']) && !empty($_POST['sopArr']) ? $_POST['sopArr'] : false;

// Default Response
$status = false;
$data = "";
$message = "Kesalahan Tidak Diketahui";

if (!$jp_ids_str) {
  $status = true;
  $message = "Data Checkbox Invalid!";
}
// die();
if (!$status) {
  $jp_id_arr = explode(',', $jp_ids_str);
  $query = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(waktu))) as total_waktu FROM jenis_perawatan WHERE jp_id IN ($jp_ids_str)";
  $execQuery = mysqli_query($con, $query);
  
  if($execQuery){
    if (mysqli_num_rows($execQuery) == 1) {
      $resQuery = mysqli_fetch_assoc($execQuery);
      $data = array(
        'request' => $jp_id_arr,
        'total_sop_time_est' => $resQuery['total_waktu']
      );
    }
    $status = true;
    $message = "Query Sukses!";
  }else{
    $status = true;
    $message = "Query Gagal! ".mysqli_error($con);
  }
}

// Mengirim Response
echo json_encode(
  array(
    "status" => $status,
    "message" => $message,
    "data" => $data
  )
);