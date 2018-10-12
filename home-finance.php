<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['nama_user'])){
  header("location:login.php");
    // die('location:login.php');//jika belum login jangan lanjut
}
?>

<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">
  <title>Form Pengajuan Budget</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

  </head>
  <body>

    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="home-finance.php">Budget-Ing</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li class="active"><a href="home-finance.php">Home</a></li>

            <?php
            $hakakses = $_SESSION['hak_akses'];
            if ($hakakses == 'Fani'){
            ?>
            <li><a href="list-finance-fani.php">List</a></li>
            <?php }
            else if ($hakakses == 'Manager'){
            ?>
            <li><a href="list-finance-budewi.php">List</a></li>
            <?php 
            }
            else {
            ?>
            <li><a href="list-finance.php">List</a></li>
            <?php } ?>
            <li><a href="history-finance.php">History</a></li>
            <li><a href="list.php">Personal</a></li>
            <li><a href="summary-finance.php">Summary</a></li>
          </ul>

          <?php
          include "koneksi.php";
          $cari = mysql_query("SELECT * FROM bpu WHERE status ='Belum Di Bayar' AND persetujuan !='Belum Disetujui'");
          $belbyr = mysql_num_rows($cari);
          ?>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-inbox"></i><span class="label label-warning"><?=$belbyr?></span></a>
                    <ul class="dropdown-menu">
          <?php
          while ($wkt = mysql_fetch_array($cari)){
          $wktulang = $wkt['waktu'];
          $selectnoid = mysql_query("SELECT * FROM pengajuan WHERE waktu='$wktulang'");
          $noid = mysql_fetch_assoc($selectnoid);
          $kode = $noid['noid'];
          $project = $noid['nama'];
          ?>
          <li class="header"><a href="view-finance.php?code=<?=$kode?>">Project <b><?=$project?></b> BPU Belum Dibayar</a></li>
          <?php
          }
          ?>
                    </ul>
            </li>
            <li><a href="#"><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION['nama_user']; ?> (<?php echo $_SESSION['divisi']; ?>)</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

<br/><br/>

  <div class="container">

    <a href="home.php?page=1"><button type="button" class="btn btn-primary">Tambah Baru</button></a>

    <br/><br/>

    <?php
    include "isi.php";
    ?>

  </div>

      </body>
    </html>
