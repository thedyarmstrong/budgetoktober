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
            <li><a href="home-finance.php">Home</a></li>
            <?php
            $hakakses = $_SESSION['hak_akses'];
            if ($hakakses == 'Fani'){
            ?>
            <li><a href="list-finance-fani.php">List</a></li>
            <?php }
            else {
            ?>
            <li><a href="list-finance.php">List</a></li>
            <?php } ?>
            <li class="active"><a href="history-finance.php">History</a></li>
            <li><a href="summary-finance.php">Summary</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION['nama_user']; ?> (<?php echo $_SESSION['divisi']; ?>)</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

<br/><br/>

<div class="container">

  <h3>History Pembayaran Memo</h3>

  <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
      <div class="panel-body no-padding">
        <table class="table table-striped table-bordered">
          <thead>
            <tr class="warning">
              <th>No</th>
              <th>Tanggal Pembayaran</th>
              <th>Jumlah</th>
              <th>Bank</th>
              <th>Nomor Rekening</th>
              <th>Nama Penerima</th>
              <th>Pengaju BPU(Divisi)</th>
            </tr>
          </thead>

          <tbody>

            <?php
            include "koneksi.php";
            $i=1;
            $sql=mysql_query("SELECT * FROM bpu WHERE status='Telah Di Bayar' ORDER BY tanggalbayar ");
            while ($a=mysql_fetch_array($sql)) {
            ?>
            <tr>
              <th scope="row"><?php echo $i++; ?></th>
              <td><?php echo $a['tanggalbayar'];?></td>
              <td><?php echo $a['jumlah'];?></td>
              <td><?php echo $a['namabank'];?></td>
              <td><?php echo $a['norek'];?></td>
              <td><?php echo $a['namapenerima'];?></td>
              <td><?php echo $a['pengaju'];?>(<?php echo $a['divisi'];?>)</td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        </div><!-- /.table-responsive -->
      </div>

</div>

    </body>
  </html>
