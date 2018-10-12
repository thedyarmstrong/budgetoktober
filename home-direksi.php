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
          <a class="navbar-brand" href="home-direksi.php">Budget-Ing</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li class="active"><a href="home-direksi.php">Home</a></li>
            <li><a href="list-direksi.php">List</a></li>
            <li><a href="summary.php">Summary</a></li>
            <!-- <li><a href="history-direksi.php">History</a></li> -->
          </ul>

          <?php
          include "koneksi.php";
          $cari = mysql_query("SELECT * FROM pengajuan WHERE status='Pending'");
          $belbyr = mysql_num_rows($cari);
          $caribpu = mysql_query("SELECT * FROM bpu WHERE persetujuan='Belum Disetujui'");
          $bpuyahud = mysql_num_rows($caribpu);
          $notif = $belbyr + $bpuyahud;
          ?>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-inbox"></i><span class="label label-warning"><?php echo $notif; ?></span></a>
                    <ul class="dropdown-menu">
          <?php
          if(mysql_num_rows($cari)==0){
            echo "";
          }else{
          while ($wkt = mysql_fetch_array($cari)){
          $wktulang = $wkt['waktu'];
          $selectnoid = mysql_query("SELECT * FROM pengajuan WHERE waktu='$wktulang'");
          $noid = mysql_fetch_assoc($selectnoid);
          $kode = $noid['noid'];
          $project = $noid['nama'];
          ?>
          <li class="header"><a href="view-direksi.php?code=<?=$kode?>">Project <b><?=$project?></b> status masih Pending</a></li>
          <?php
          }
          }
          while ($wktbpu = mysql_fetch_array($caribpu)){
          $bpulagi = $wktbpu['waktu'];
          $selectnoid2 = mysql_query("SELECT * FROM pengajuan WHERE waktu='$bpulagi'");
          $noid2 = mysql_fetch_assoc($selectnoid2);
          $kode2 = $noid2['noid'];
          $project2 = $noid2['nama'];
          ?>
          <li class="header"><a href="views-direksi.php?code=<?=$kode2?>">Project <b><?=$project2?></b> ada BPU yang belum di setujui</a></li>
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
