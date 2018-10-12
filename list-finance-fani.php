<?php
error_reporting(0);
include "koneksi.php";
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
          <a class="navbar-brand" href="home-hrd.php">Budget-Ing</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li><a href="home-finance.php">Home</a></li>
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
          </ul>
          <?php
          include "koneksi.php";
          $cari = mysql_query("SELECT * FROM bpu WHERE status='Belum Di Bayar'");
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

<div class="container">

          <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
              <div class="panel-body no-padding">
                <table class="table table-striped">
                  <thead>
                    <tr class="warning">
                      <th>No</th>
                      <th>Nama Project</th>
                      <th>Jenis</th>
                      <th>Tahun</th>
                      <th>Nama Yang Mengajukan</th>
                      <th>Divisi</th>
                      <th>Action</th>
                      <th>Status</th>
                    </tr>
                  </thead>

                  <tbody>

                    <?php
                    include "koneksi.php";
                    $i=1;
                    $sql=mysql_query("SELECT * FROM pengajuan WHERE jenis ='Rutin' OR jenis ='Non Rutin' AND status !='Belum Di Ajukan' ORDER BY nama");
                    while ($d=mysql_fetch_array($sql)) {

                      if($d['status'] == "Disetujui"){
                    ?>
                    <tr>
                      <th bgcolor="#fcfaa4" scope="row"><?php echo $i++; ?></th>
                      <td bgcolor="#fcfaa4"><?php echo $d['nama'];?></td>
                      <td bgcolor="#fcfaa4"><?php echo $d['jenis'];?></td>
                      <td bgcolor="#fcfaa4"><?php echo $d['tahun'];?></td>
                      <td bgcolor="#fcfaa4"><?php echo $d['pengaju'];?></td>
                      <td bgcolor="#fcfaa4"><?php echo $d['divisi'];?></td>
                      <td bgcolor="#fcfaa4">
                      <?php
                      if ($hakakses == 'Manager'){
                      ?>
                      <a href="view-finance-manager.php?code=<?php echo $d['noid'];?>"><i class="fas fa-eye" title="VIEW"></i></a>
                      <?php
                      }else{
                      ?>
                        <a href="view-finance.php?code=<?php echo $d['noid'];?>"><i class="fas fa-eye" title="VIEW"></i></a>
                      <?php } ?>
                      </td>
                      <td bgcolor="#fcfaa4"><?php echo $d['status'];?></td>
                    </tr>
                    <?php
                      }
                      else { ?>
                    <tr>
                      <th scope="row"><?php echo $i++; ?></th>
                      <td><?php echo $d['nama'];?></td>
                      <td><?php echo $d['jenis'];?></td>
                      <td><?php echo $d['tahun'];?></td>
                      <td><?php echo $d['pengaju'];?></td>
                      <td><?php echo $d['divisi'];?></td>
                      <td>--</td>
                      <td><?php echo $d['status'];?></td>
                    </tr>
                    <?php } }?>
                  </tbody>
                </table>
                </div><!-- /.table-responsive -->
              </div>

</div>

</body>
</html>
