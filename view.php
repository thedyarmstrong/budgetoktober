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
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION['nama_user']; ?> (<?php echo $_SESSION['divisi']; ?>)</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

<div class="container">

<?php

include "koneksi.php";
$code = $_GET['code'];
$select = mysql_query("SELECT * FROM pengajuan WHERE noid='$code'");
$d=mysql_fetch_assoc($select);
?>

<center><h2><?php echo $d['nama']; ?></h2></center>

<br/><br/>

<div class="row">
    <div class="col-xs-2">Nama Yang Mengajukan</div>
    <div class="col-xs-3">: <b><?php echo $d['pengaju']; ?></b></div>
</div>

<div class="row">
    <div class="col-xs-2">Divisi</div>
    <div class="col-xs-3">: <b><?php echo $d['divisi']; ?></b></div>
</div>

<div class="row">
    <div class="col-xs-2">Tahun</div>
    <div class="col-xs-3">: <b><?php echo $d['tahun']; ?></b></div>
</div>

<br/><br/>

  <div class="but_list">
    <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">

  <ul id="myTab" class="nav nav-tabs" role="tablist">

   <li role="presentation" class="active">
     <a href="#budget" id="budget-tab" role="tab" data-toggle="tab" aria-controls="budget" aria-expanded="true">Budget</a>
   </li>

   <li role="presentation">
     <a href="#history" role="tab" id="history-tab" data-toggle="tab" aria-controls="history">History</a>
   </li>

  </ul>

  <div id="myTabContent" class="tab-content"><!-- Tab -->

<div role="tabpanel" class="tab-pane fade in active" id="budget" aria-labelledby="home-tab">

<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
    <div class="panel-body no-padding">
      <table class="table table-striped table-bordered">
        <thead>
          <tr class="warning">
            <th>No</th>
            <th>Nama</th>
            <th>Kota</th>
            <th>Status</th>
            <th>Penerima Uang</th>
            <th>Harga (IDR)</th>
            <th>Total Quantity</th>
            <th>Total Harga (IDR)</th>
            <th>Sisa Pembayaran</th>
            <th>Edit</th>
            <?php
            $waktu = $d['waktu'];
            $selno = mysql_query("SELECT no FROM selesai WHERE waktu ='$waktu'");
            $wkwk = mysql_fetch_assoc($selno);
            $no = $wkwk['no'];
            $liatbayarth = mysql_query("SELECT * FROM pembayaran WHERE waktu='$waktu' AND no='$no'");
            if(mysql_num_rows($liatbayarth) == 0) {
               echo "";
             }
             else
             {
               $n = 1;
               while($bayar=mysql_fetch_array($liatbayarth)){
               echo "<th>Term Pembayaran " .$n++. "</th>";
             }
            }?>
          </tr>
        </thead>

        <tbody>

          <?php
          $i=1;
          $waktu = $d['waktu'];
          $sql=mysql_query("SELECT * FROM selesai WHERE waktu='$waktu' ORDER BY no");
          while ($a=mysql_fetch_array($sql)) {

          ?>

          <tr>
            <th scope="row"><?php echo $i++; ?></th>
            <td><?php echo $a['rincian'];?></td>
            <td><?php echo $a['kota'];?></td>
            <td><?php echo $a['status'];?></td>
            <td><?php echo $a['penerima'];?></td>
            <td><?php echo 'Rp. ' . number_format( $a['harga'], 0 , '' , ',' ); ?></td>
            <td><center><?php echo $a['quantity'];?></center></td>
            <td><?php echo 'Rp. ' . number_format( $a['total'], 0 , '' , ',' ); ?></td>

            <!-- Sisa Pembayaran -->
            <?php
            $no = $a['no'];
            $waktu = $a['waktu'];
            $pilihtotal = mysql_query("SELECT total FROM selesai WHERE no='$no' AND waktu='$waktu'");
            $aw = mysql_fetch_assoc($pilihtotal);
            $hargaah = $aw['total'];
            $query="SELECT sum(jumlahbayar) AS sum FROM pembayaran WHERE no='$no' AND waktu='$waktu'";
            $result=mysql_query($query);
            $row=mysql_fetch_array($result);
            $total=$row[0];
            $jadinya = $hargaah - $total
            ?>
            <td><?php echo 'Rp. ' . number_format( $jadinya, 0 , '' , ',' ); ?></td>
            <!-- //Sisa Pembayaran -->

            <td><button type="button" class="btn btn-default btn-small" onclick="edit_budget('<?php echo $no; ?>','<?php echo $waktu; ?>')">Edit</button></td>

            <?php
            $liatbayar = mysql_query("SELECT * FROM pembayaran WHERE waktu='$waktu' AND no='$no'");
            if(mysql_num_rows($liatbayar) == 0) {
               echo "";
             }
             else
             {
               while($bayar=mysql_fetch_array($liatbayar)){
               $jumlbayar = $bayar['jumlahbayar'];
               $novouch   = $bayar['nomorvoucher'];
               $tglbyr    = $bayar['tanggalbayar'];
               echo "<td>Pembayaran : <b>Rp. " . number_format($jumlbayar, 0 , '' , ',');
               echo "<br>";
               echo "No.Voucher : $novouch ";
               echo "<br>";
               echo "Tanggal : $tglbyr ";
               echo "</b></td>";
             }
            }?>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      </div><!-- /.table-responsive -->
    </div>

<br/><br/>

    <div class="row">
        <div class="col-xs-3">Total Keseluruhan</div>
        <div class="col-xs-3">: <b><?php echo 'Rp. ' . number_format( $d['totalbudget'], 0 , '' , ',' ); ?></b></div>
    </div>

    <div class="row">
        <div class="col-xs-3">Total Yang Sudah Di bayarkan</div>

        <?php

        $query2="SELECT sum(jumlahbayar) AS sum FROM pembayaran WHERE waktu='$waktu'";
        $result2=mysql_query($query2);
        $row2=mysql_fetch_array($result2);
        ?>

        <div class="col-xs-3">: <b><?php echo 'Rp. ' . number_format( $row2['sum'], 0 , '' , ',' ); ?></b></div>
    </div>


<!-- Yang belum Bayar -->
    <div class="row">
        <div class="col-xs-3">Total Yang Belum Di bayarkan</div>
        <?php
          $aaaa = $d['totalbudget'];
          $bbbb = $row2['sum'];
          $belumbayar = $aaaa - $bbbb;

         ?>
        <div class="col-xs-3">: <b><?php echo 'Rp. ' . number_format( $belumbayar, 0 , '' , ',' ); ?></b></div>
    </div>
<!-- // Yang belum bayar -->

<br/><br/>

<button type="button" class="btn btn-default btn-small" onclick="tambah_budget('<?php echo $waktu; ?>','<?php echo $code; ?>')">Tambah</button>

<br/><br/>


<h3>Memo Upload</h3>
<table class="table table-striped table-bordered">
  <thead>
    <tr class="warning">
      <th>No</th>
      <th>Gambar</th>
      <th>Status</th>
      <th>Tanggal Dan Jam</th>
  </thead>

  <tbody>
    <?php
    $selupload = mysql_query("SELECT * FROM upload WHERE waktu='$waktu' AND status='Belum Dibayar'");
    $i=1;
    while($su=mysql_fetch_array($selupload)){
    ?>
      <tr>
        <td><?php echo $i++ ?></td>
        <td><a href="uploads/<?php echo $su['gambar']; ?>"><img src="uploads/<?php echo $su['gambar']; ?>" width="75" height="75"></a></td>
        <td><?php echo $su['status']; ?></td>
        <td><?php echo $su['timestam']; ?></td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>

</div>

<div role="tabpanel" class="tab-pane fade" id="history" aria-labelledby="history-tab">
  <h3>History Pembayaran Memo</h3>
  <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
      <div class="panel-body no-padding">
        <table class="table table-striped table-bordered">
          <thead>
            <tr class="warning">
              <th>No</th>
              <th>Gambar</th>
              <th>Tanggal Upload</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include "koneksi.php";
            $i=1;
            $divisi = $_SESSION['divisi'];
            $sql=mysql_query("SELECT * FROM upload WHERE waktu='$waktu' AND status='Telah Dibayar'");
            while ($a=mysql_fetch_array($sql)) {
            ?>
            <tr>
              <th scope="row"><?php echo $i++; ?></th>
              <td><a href="uploads/<?php echo $a['gambar']; ?>"><img src="uploads/<?php echo $a['gambar']; ?>" width="75" height="75"></a></td>
              <td><?php echo $a['timestam'];?></td>
              <td><?php echo $a['status'];?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        </div><!-- /.table-responsive -->
      </div>
</div>

</div><!-- //Tab -->

</div><!-- //Container -->

<div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Budget</h4>
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

  <div class="modal fade" id="myModal3" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">UPLOAD MEMO</h4>
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

  <div class="modal fade" id="myModal2" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tambah Budget</h4>
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
      // $(document).ready(function(){
      //     $('#myModal').on('show.bs.modal', function (e) {
      //         var rowid = $(e.relatedTarget).data('id');
      //         //menggunakan fungsi ajax untuk pengambilan data
      //         $.ajax({
      //             type : 'post',
      //             url : 'editbudget.php',
      //             data :  'rowid='+ rowid,
      //             success : function(data){
      //             $('.fetched-data').html(data);//menampilkan data ke dalam modal
      //             }
      //         });
      //      });
      //
      //      $('.edit_budget').on('click', function (e) {
      //          var noid = '<?php //echo $noid; ?>';
      //          var waktu = '<?php //echo $waktu; ?>';
      //          //menggunakan fungsi ajax untuk pengambilan data
      //          $.ajax({
      //              type : 'post',
      //              url : 'editbudget.php',
      //              data :  {noid:noid, waktu:waktu},
      //              success : function(data){
      //                $('.fetched-data').html(data);//menampilkan data ke dalam modal
      //                $('#myModal').modal();
      //              }
      //          });
      //       });
      //
      // });

      function edit_budget(no,waktu){
        // alert(noid+' - '+waktu);
        $.ajax({
            type : 'post',
            url  : 'editpengaju.php',
            data :  {no:no, waktu:waktu},
            success : function(data){
              $('.fetched-data').html(data);//menampilkan data ke dalam modal
              $('#myModal').modal();
            }
        });
      }

      function tambah_budget(waktu,noid){
        // alert(noid+' - '+waktu);
        $.ajax({
            type : 'post',
            url  : 'tambahpengaju.php',
            data :  {waktu:waktu, noid:noid},
            success : function(data){
              $('.fetched-data').html(data);//menampilkan data ke dalam modal
              $('#myModal2').modal();
            }
        });
      }

      function upload(no,waktu){
        // alert(noid+' - '+waktu);
        $.ajax({
            type : 'post',
            url  : 'upload.php',
            data :  {no:no, waktu:waktu},
            success : function(data){
              $('.fetched-data').html(data);//menampilkan data ke dalam modal
              $('#myModal3').modal();
            }
        });
      }
    </script>

</body>
</html>
