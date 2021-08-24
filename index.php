<?php
  session_start();
  ob_start();
  
  include "lib/config.php";
  
  /*
    if(empty($_SESSION['username']) or empty($_SESSION['password'])){
       echo "<p align='center'> Anda harus login terlebih dahulu!</p>";
       echo "<meta http-equiv='refresh' content='2; url=login.php'>";
    }else{
      if (isset($_SESSION['id_logArr']) && !empty($_SESSION['id_logArr'])) {
          // Cek jika sudah login melalui sop middleware(ceklogin)
          if(in_array('sop',$_SESSION['id_logArr'])){
              define('INDEX', true);
              $level = preg_replace("/\s+/", "", $_SESSION['level']); // Menghapus spasi, tabs atau new line pada string
              $ID_CURRENT_USER = $_SESSION['id_user'];
              // $ID_PEGAWAI_CURRENT_USER = $_SESSION['id_pegawai'];
          } else {
              echo "<p align='center'> Anda harus login terlebih dahulu!</p>";
              echo "<meta http-equiv='refresh' content='2; url=login.php'>";
              die();
          }
      }
  */

  if (!isset($_SESSION['sop_sessionArr']) || empty($_SESSION['sop_sessionArr']) ) {
    echo "<p align='center'> Anda harus login terlebih dahulu!</p>";
    echo "<meta http-equiv='refresh' content='2; url=login.php'>";
  } else {
    define('INDEX', true);
    $level = preg_replace("/\s+/", "", $_SESSION['sop_sessionArr']['level']); // Menghapus spasi, tabs atau new line pada string
    $ID_CURRENT_USER = $_SESSION['sop_sessionArr']['id_user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOP SalMum</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Stencil+Text:wght@300;400&family=Coustard&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/tabbis.min.css"/>
    <link rel="stylesheet" href="css/skotchmodal.css"/>
    <!-- <link rel="stylesheet" href="css/style1.css"/> -->
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css"/> -->
</head>
<body>
    
    <nav>
        <div class="logo">
            <h4>SOP Salon Mumtaza</h4>
        </div>
        <ul <?php echo $level != 'owner' ? 'id="not-owner-nav"' : '';?>>
            <li class="dropbtn"><a href="?hal=sop">Home</a></li>
            <?php if($level == 'owner') : ?>
                <li class="dropbtn1"><a href="?hal=rekap_harian">Rekap SOP Harian</a></li>
                <li class="dropbtn2"><a href="?hal=rekap_bulanan">Rekap SOP Bulanan</a></li>
            <?php endif; ?>
            <!-- penutup level -->
            <li>
                <a href="logout.php">Logout</a>
            </li>
        </ul>

        <div class="menu-toggle">
            <input type="checkbox"/>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <!-- Isi Kontent -->
    <section class="main">
        <div class="scrollable-wrapper">
            <?php include "konten.php"; ?>
        </div>
    </section>
    <footer>
        Copyright &copy; Abka Zailani
    </footer>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/tabbis.es6.min.js"></script>
    <script src="js/skotchmodal.js"></script>
    <script src="js/filereader.js"></script>
</body>
</html>
<?php
   }
?>