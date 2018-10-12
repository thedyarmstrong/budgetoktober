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
          <a class="navbar-brand" href="home.php">Budget-Ing</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li><a href="home.php">Home</a></li>
            <li class="active"><a href="list.php">List</a></li>
            <!-- <li><a href="history.php">History</a></li> -->
          </ul>

            <?php
            include "koneksi.php";
            $pengaju = $_SESSION['nama_user'];
            $cari = mysql_query("SELECT * FROM bpu WHERE pengaju ='$pengaju' AND persetujuan ='Belum Disetujui' OR pengaju ='$pengaju' AND persetujuan ='Pending'");
            $belbyr = mysql_num_rows($cari);
            $cobaah = mysql_fetch_assoc($cari);
            ?>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-inbox"></i><span class="label label-warning"><?=$belbyr?></span></a>
                      <ul class="dropdown-menu">
            <?php
            while ($wkt = mysql_fetch_array($cari)){
            $pers = $wkt['persetujuan'];
            $wktulang = $wkt['waktu'];
            $selectnoid = mysql_query("SELECT * FROM pengajuan WHERE waktu='$wktulang'");
            $noid = mysql_fetch_assoc($selectnoid);
            $kode = $noid['noid'];
            $project = $noid['nama'];

            if ($pers == 'Belum Disetujui'){
            ?>
            <li class="header"><a href="view-finance.php?code=<?=$kode?>">Project <b><?=$project?></b> BPU Belum Dibayar</a></li>
            <?php
            }else if ($pers == 'Pending'){
            ?>
            <li class="header"><a href="view-finance.php?code=<?=$kode?>">Project <b><?=$project?></b> ada BPU Yang Harus Segera Di Tindak Lanjuti</a></li>
            <?php
            }
            }
            ?>
                      </ul>
              </li>

          <ul class="nav navbar-nav navbar-right">
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
              <th>Tahun</th>
              <th>Nama Yang Mengajukan</th>
              <th>Divisi</th>
              <th>Action</th>
              <th>Status</th>
              <th>Pengajuan</th>
            </tr>
          </thead>

          <tbody>
            <?php
            include "koneksi.php";
            $i=1;
            $divisi = $_SESSION['divisi'];
	          $username = $_SESSION['nama_user'];

            if($username == 'Suci Indah Sari'){
            $sql=mysql_query("SELECT * FROM pengajuan WHERE jenis ='B1' AND status !='Belum Di Ajukan' OR jenis ='B2' AND status !='Belum Di Ajukan' ORDER BY jenis");
            }else{
            $sql=mysql_query("SELECT * FROM pengajuan WHERE divisi ='$divisi'");
            }
            while ($d=mysql_fetch_array($sql)) {

              if($d['status'] == "Belum Di Ajukan"){
            ?>
                <tr>
                  <th scope="row"><?php echo $i++; ?></th>
                  <td><?php echo $d['nama'];?></td>
                  <td><?php echo $d['tahun'];?></td>
                  <td><?php echo $d['pengaju'];?></td>
                  <td><?php echo $d['divisi'];?></td>
                  <td><a href="view.php?code=<?php echo $d['noid'];?>"><i class="fas fa-eye" title="VIEW"></i></a></td>
                  <td><?php echo $d['status'];?></td>
                  <?php echo "<td><a href='#myModal' class='btn btn-default btn-small' id='custId' data-toggle='modal' data-id=".$d['noid'].">Ajukan</a></td>"; ?>
                </tr>
            <?php
              }
              else if($d['status'] == "Pending"){
            ?>
                <tr>
                  <th scope="row"><?php echo $i++; ?></th>
                  <td><?php echo $d['nama'];?></td>
                  <td><?php echo $d['tahun'];?></td>
                  <td><?php echo $d['pengaju'];?></td>
                  <td><?php echo $d['divisi'];?></td>
                  <td><a href="view.php?code=<?php echo $d['noid'];?>"><i class="fas fa-eye" title="VIEW"></i></a></td>
                  <td><?php echo $d['status'];?></td>
                  <?php echo "<td>--</td>"; ?>
                </tr>
              <?php
              }
              else
              {
              ?>
            <tr>
              <th scope="row"><?php echo $i++; ?></th>
              <td><?php echo $d['nama'];?></td>
              <td><?php echo $d['tahun'];?></td>
              <td><?php echo $d['pengaju'];?></td>
              <td><?php echo $d['divisi'];?></td>
              <td><a href="views.php?code=<?php echo $d['noid'];?>"><i class="fas fa-eye" title="VIEW"></i></a></td>
              <td><?php echo $d['status'];?></td>
              <?php echo "<td>--</td>"; ?>
            </tr>
          <?php } }?>

          </tbody>
        </table>
        </div><!-- /.table-responsive -->
      </div>

    </div>

    <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Pengajuan</h4>
                  </div>
                  <div class="modal-body">
                      <div class="fetched-data"></div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                  </div>
              </div>
          </div>
      </div>

        <script type="text/javascript">
          $(document).ready(function(){
              $('#myModal').on('show.bs.modal', function (e) {
                  var rowid = $(e.relatedTarget).data('id');
                  //menggunakan fungsi ajax untuk pengambilan data
                  $.ajax({
                      type : 'post',
                      url : 'ajukan.php',
                      data :  'rowid='+ rowid,
                      success : function(data){
                      $('.fetched-data').html(data);//menampilkan data ke dalam modal
                      }
                  });
               });
          });
        </script>
</body>
</html>
