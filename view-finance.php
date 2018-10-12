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
            <li><a href="history-finance.php">History</a></li>
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
    <div class="col-sm-2">Nama Yang Mengajukan</div>
    <div class="col-sm-6">: <b><?php echo $d['pengaju']; ?></b></div>
    <div class="col-sm-4"><b>M&nbsp;&nbsp; = <img src="images/pink.png" width="20px" height="15px"> Pengajuan BPU (Internal)</b></div>
</div>

<div class="row">
    <div class="col-sm-2">Divisi</div>
    <div class="col-sm-6">: <b><?php echo $d['divisi']; ?></b></div>
    <div class="col-sm-4"><b>B&nbsp;&nbsp; = <img src="images/biru.png" width="20px" height="15px"> Pengajuan BPU (External)</b></div>
</div>

<div class="row">
    <div class="col-sm-2">Tahun</div>
    <div class="col-sm-6">: <b><?php echo $d['tahun']; ?></b></div>
    <div class="col-sm-4"><b>K&nbsp;&nbsp; = <img src="images/kuning.png" width="20px" height="15px"> BPU Disetujui</b></div>
</div>

<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-6"></div>
    <div class="col-sm-4"><b>HT = <img src="images/hijautua.png" width="20px" height="15px"> BPU Sudah Dibayar & <u>Belum Realisasi</u></b></div>
</div>

<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-6"></div>
    <div class="col-sm-4"><b>H&nbsp;&nbsp; = <img src="images/hijau.png" width="20px" height="15px"> BPU Sudah Dibayar & <u>Sudah Realisasi</u></b></div>
</div>

<br><br>

<div class="but_list">
  <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">

<ul id="myTab" class="nav nav-tabs" role="tablist">

 <li role="presentation" class="active">
   <a href="#budget" id="budget-tab" role="tab" data-toggle="tab" aria-controls="budget" aria-expanded="true">Budget</a>
 </li>

 <li role="presentation">
   <a href="#history" role="tab" id="history-tab" data-toggle="tab" aria-controls="history">History</a>
 </li>

 <li role="presentation">
   <a href="#rincian" role="tab" id="rincian-tab" data-toggle="tab" aria-controls="rincian">Rincian BPU</a>
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
            <th>Rincian & Keterangan</th>
            <th>Kota</th>
            <th>Status</th>
            <th>Penerima Pembayaran</th>
            <th>Harga Satuan (IDR)</th>
            <th>Quantity</th>
            <th>Total Harga (IDR)</th>
            <th>Sisa Pembayaran</th>
            <th>Pembayaran</th>

            <?php
            $waktu = $d['waktu'];
            $selno = mysql_query("SELECT no FROM selesai WHERE waktu ='$waktu'");
            $wkwk = mysql_fetch_assoc($selno);
            $no = $wkwk['no'];
            $liatbayarth = mysql_query("SELECT * FROM bpu WHERE waktu='$waktu' AND no='$no'");
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
          $no = $a['no'];
          $waktu = $a['waktu'];
          ?>
          <tr>
            <th scope="row"><?php echo $i++; ?></th>
            <td><?php echo $a['rincian'];?></td>
            <td><?php echo $a['kota'];?></td>
            <td><?php echo $a['status'];?></td>
            <td><?php echo $a['penerima'];?></td>
            <td><?php echo 'Rp. ' . number_format( $a['harga'], 0 , '' , ',' ); ?></td>
            <td><?php echo $a['quantity'];?></td>
            <td><?php echo 'Rp. ' . number_format( $a['total'], 0 , '' , ',' ); ?></td>

            <!-- Sisa Pembayaran -->
            <?php
            $no = $a['no'];
            $waktu = $a['waktu'];
            $pilihtotal = mysql_query("SELECT total FROM selesai WHERE no='$no' AND waktu='$waktu'");
            $aw = mysql_fetch_assoc($pilihtotal);
            $hargaah = $aw['total'];
            $query="SELECT sum(jumlahbayar) AS sum FROM bpu WHERE no='$no' AND waktu='$waktu'";
            $result=mysql_query($query);
            $row=mysql_fetch_array($result);
            $total=$row[0];
            $query16="SELECT sum(uangkembali) AS sum FROM bpu WHERE no='$no' AND waktu='$waktu'";
            $result16=mysql_query($query16);
            $row16=mysql_fetch_array($result16);
            $total16=$row16[0];
            $jadinya = ($hargaah - $total) + $total16
            ?>
            <td><?php echo 'Rp. ' . number_format( $jadinya, 0 , '' , ',' ); ?></td>
            <!-- //Sisa Pembayaran -->

            <?php
              // if ($jadinya == 0) {
              // echo "<td>" .$jadinya. "</td>";
              // }
              // else{
                if ($a['status'] == 'UM' || $a['status'] == 'Finance' || $a['status'] == 'Pulsa' || $a['status'] == 'Biaya' || $a['status'] == 'Biaya Lumpsum'){
                  ?>
                  <td><button type="button" class="btn btn-default btn-small" onclick="edit_budget('<?php echo $no; ?>','<?php echo $waktu; ?>')">Bayar</button></td>
              <?php
                }else{
                  ?>
                  <td><button type="button" class="btn btn-default btn-small" onclick="eksternal_finance('<?php echo $no; ?>','<?php echo $waktu; ?>')">Eksternal</button></td>
              <?php
                }
              // }
              $liatbayar = mysql_query("SELECT * FROM bpu WHERE waktu='$waktu' AND no='$no'");
              if(mysql_num_rows($liatbayar) == 0) {
                 echo "";
               }
               else
               {
                 while($bayar=mysql_fetch_array($liatbayar)){
                 $jumlbayar          = $bayar['jumlah'];
                 $tglbyr             = $bayar['tglcair'];
                 $statusbayar        = $bayar['status'];
                 $persetujuan        = $bayar['persetujuan'];
                 $novoucher          = $bayar['novoucher'];
                 $tanggalbayar       = $bayar['tanggalbayar'];
                 $nobay              = $bayar['no'];
                 $termm              = $bayar['term'];
                 $wakbay             = $bayar['waktu'];
                 $alasan             = $bayar['alasan'];
                 $realisasi          = $bayar['realisasi'];
                 $uangkembali        = $bayar['uangkembali'];
                 $tanggalrealisasi   = $bayar['tanggalrealisasi'];
                 $termreal           = $bayar['term'];
                 $namabank           = $bayar['namabank'];
                 $namapenerima       = $bayar['namapenerima'];
                 $norek              = $bayar['norek'];
                 $tglcair            = $bayar['tglcair'];
                 $jumlahjadi         = $jumlbayar - $uangkembali;
                 $pengaju            = $bayar['pengaju'];
                 $divisi2            = $bayar['divisi'];
                 $pembayar           = $bayar['pembayar'];

                 $selstat = mysql_query("SELECT status FROM selesai WHERE waktu='$waktu' AND no='$no'");
                 $ss = mysql_fetch_assoc($selstat);
                 $exin = $ss['status'];

                 if ($persetujuan == 'Belum Disetujui' && $statusbayar == 'Belum Di Bayar'){
                   $color = '#ffd3d3';
                 }
                 else if (($persetujuan == 'Disetujui (Direksi)' || $persetujuan == 'Disetujui (Sri Dewi Marpaung)') && $statusbayar == 'Belum Di Bayar'){
                   $color = '#fff5c6';
                 }
                 else if ($persetujuan == 'Pending' && $statusbayar == 'Belum Di Bayar'){
                   $color = 'orange';
                 }
                 else if (($persetujuan == 'Disetujui (Direksi)' || $persetujuan == 'Disetujui (Sri Dewi Marpaung)') && $statusbayar == 'Telah Di Bayar' && ($exin == 'Honor Eksternal' || $exin == 'Vendor/Supplier' || $exin == 'Lumpsum')){
                   $color = '#d5f9bd';
                 }
                 else if (($persetujuan == 'Disetujui (Direksi)' || $persetujuan == 'Disetujui (Sri Dewi Marpaung)') && $statusbayar == 'Telah Di Bayar' && ($exin == 'Pulsa' || $exin == 'Biaya External' || $exin == 'Biaya' || $exin == 'Biaya Lumpsum')){
                   $color = '#d5f9bd';
                 }
                 else if (($persetujuan == 'Disetujui (Direksi)' || $persetujuan == 'Disetujui (Sri Dewi Marpaung)') && $statusbayar == 'Telah Di Bayar' && $exin == 'UM'){
                   $color = '#8aad70';
                 }
                 else if (($persetujuan == 'Disetujui (Direksi)' || $persetujuan == 'Disetujui (Sri Dewi Marpaung)') && $statusbayar == 'Realisasi (Direksi)' && $exin == 'UM'){
                   $color = '#d5f9bd';
                 }
                 else if (($persetujuan == 'Disetujui (Direksi)' || $persetujuan == 'Disetujui (Sri Dewi Marpaung)') && $statusbayar == 'Realisasi (Finance)' && $exin == 'UM'){
                   $color = '#d5f9bd';
                 }

                 echo "<td bgcolor=' $color '>";
                 echo "No :<b> $termm";
                 echo "</b><br>";
                 echo "Request BPU : <br><b>Rp. " . number_format($jumlahjadi, 0 , '' , ',');
                 echo "</b><br>";
                 echo "Tanggal : <br><b> ".date('Y-m-d',strtotime($waktustempel));
                 echo "</b><br>";
                 echo "Jam : <b>".date('H:i:s',strtotime($waktustempel));
                 echo "</b></br>";
                 echo "Tanggal Terima Uang : <b>$tglcair ";
                 echo "</b></br>";
                 echo "Dibuat Oleh : <br><b> $pengaju($divisi2)";
                 echo "</b><br>";
                 echo "Dibayarkan Kepada : <br><b> $namapenerima ";
                 echo "</b><br>";
                 echo "No Rekening :<b> $norek";
                 echo "</b><br>";
                 echo "Bank :<b> $namabank";
                 echo "</b><br>";
                 echo "No Voucher : <br><b> $novoucher ";
                 echo "</b><br/>";
                 echo "Tgl Bayar : <br><b> $tanggalbayar";
                 echo "</b><br/>";
                 echo "Kasir : <br><b> $pembayar ";
                 echo "</b><br/>";

                     if ($persetujuan == 'Belum Disetujui' && $statusbayar == 'Belum Di Bayar'){
                       echo "<i class='far fa-check-square'></i> Pengajuan ";
                       echo "</b><br/>";
                       echo "<i class='far fa-square'></i> Approval ";
                       echo "</b><br/>";
                       echo "<i class='far fa-square'></i> Paid ";
                       echo "</b><br/>";
                     }

                     else if (($persetujuan == 'Disetujui (Direksi)' || $persetujuan == 'Disetujui (Sri Dewi Marpaung)') && $statusbayar == 'Belum Di Bayar'){
                       echo "<i class='far fa-check-square'></i> Pengajuan";
                       echo "</b><br/>";
                       echo "<i class='far fa-check-square'></i> Approval";
                       echo "</b><br/>";
                       echo "<i class='far fa-square'></i> Paid ";
                       echo "</b><br/>";
                     }

                     else if (($persetujuan == 'Disetujui (Direksi)' || $persetujuan == 'Disetujui (Sri Dewi Marpaung)') && ($statusbayar == 'Telah Di Bayar' || $statusbayar == 'Realisasi (Finance)' || $statusbayar == 'Realisasi (Direksi)')){
                       echo "<i class='far fa-check-square'></i> Pengajuan";
                       echo "</b><br/>";
                       echo "<i class='far fa-check-square'></i> Approval";
                       echo "</b><br/>";
                       echo "<i class='far fa-check-square'></i> Paid ";
                       echo "</b><br/>";
                       echo "Uang Kembali :<br><b> Rp. " . number_format($uangkembali, 0 , '' , ',');
                       echo "</b><br/>";
                     }

                          if ($statusbayar == 'Realisasi (Direksi)' || $statusbayar == 'Realisasi (Finance)'){
                            echo "<button><a href='forprint.php?page=2&code=".$nobay."&waktu=".$wakbay."&term=".$termm."'>Memorial</a></button>";
                          }
                          else{
                            echo "";
                          }
                 echo "<button><a href='forprint.php?page=1&code=".$nobay."&waktu=".$wakbay."&term=".$termm."'>Print</a></button>";
                 echo "</td>";
               }
            }?>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      </div><!-- /.table-responsive -->
    </div>

    <div class="row">
        <div class="col-xs-3">Budget Total</div>
        <div class="col-xs-3">: <b><?php echo 'Rp. ' . number_format( $d['totalbudget'], 0 , '' , ',' ); ?></b></div>
    </div>

    <div class="row">
        <div class="col-xs-3"><font color="#1bd34f">Total Biaya</div>

        <?php
        $query2="SELECT sum(jumlahbayar) AS sum FROM bpu WHERE waktu='$waktu'";
        $result2=mysql_query($query2);
        $row2=mysql_fetch_array($result2);

        $q_real="SELECT sum(realisasi) AS sum FROM bpu WHERE waktu='$waktu'";
        $r_real=mysql_query($q_real);
        $g_real=mysql_fetch_array($r_real);

        $query10="SELECT sum(uangkembali) AS sum FROM bpu WHERE waktu='$waktu'";
        $result10=mysql_query($query10);
        $row10=mysql_fetch_array($result10);
        $totlah = $row2['sum'];
        $reallah = $row10['sum'];
        $tysb = $totlah - $reallah;
        ?>

        <div class="col-xs-3">: <b><?php echo 'Rp. ' . number_format( $tysb, 0 , '' , ',' ); ?></font></b></div>
    </div>


    <!-- Yang belum Bayar -->
    <div class="row">
        <div class="col-xs-3"><font color='#f23f2b'>Sisa Budget</div>
        <?php
          $aaaa = $d['totalbudget'];
          $bbbb = $row2['sum'];
          $belumbayar = $aaaa - $bbbb;
         ?>
        <div class="col-xs-3">: <b><?php echo 'Rp. ' . number_format( $belumbayar, 0 , '' , ',' ); ?></font></b></div>
    </div>
    <!-- // Yang belum bayar -->

    <!-- Ready To Pay -->
    <div class="row">
        <div class="col-xs-3"><font color='#fcce00'>Ready To Pay :</div>
        <?php
          $query3="SELECT sum(jumlah) AS sumi FROM bpu WHERE waktu='$waktu' AND persetujuan='Disetujui (Direksi)' AND status='Belum Di Bayar'";
          $result3=mysql_query($query3);
          $row3=mysql_fetch_array($result3);
         ?>
        <div class="col-xs-3">: <b><?php echo 'Rp. ' . number_format( $row3['sumi'], 0 , '' , ',' ); ?></font></b></div>
    </div>
    <!-- // Ready To Pay -->

    Note :
    <div class="row">
        <div class="col-xs-3"><font color="#cbf442">Total Uang Kembali Realisasi</div>
        <div class="col-xs-3">: <b><?php echo 'Rp. ' . number_format( $row10['sum'], 0 , '' , ',' ); ?></font></b></div>
    </div>

<br><br>

<h3>Memo Upload</h3>
<table class="table table-striped table-bordered">
  <thead>
    <tr class="warning">
      <th>No</th>
      <th>Gambar</th>
      <th>Status</th>
      <th>Pembayaran</th>
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
        <td><button type="button" class="btn btn-default btn-small" onclick="bayarmemo('<?php echo $no; ?>','<?php echo $waktu; ?>')">Bayar Memo</button></td>
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
              <td><?php echo $a['timestam'];?>
              <td><?php echo $a['status'];?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        </div><!-- /.table-responsive -->
      </div>
</div>

<div role="tabpanel" class="tab-pane fade" id="rincian" aria-labelledby="rincian-tab">
  <h3>Rincian BPU "Belum Di Bayar"</h3>
  <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
      <div class="panel-body no-padding">
        <table class="table table-striped table-bordered">
          <thead>
            <tr class="warning">
              <th>Nomor</th>
              <th>Nama Bank</th>
              <th>Nomor Rekening</th>
              <th>Nama Penerima</th>
              <th>Jenis</th>
              <th>Total BPU</th>
              <th>Req Tgl Pencairan</th>
              <th>Status</th>
              <th>Persetujuan</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql=mysql_query("SELECT * FROM bpu WHERE waktu='$waktu' AND status='Belum Di Bayar' ORDER BY no");
            while ($a=mysql_fetch_array($sql)) {
            ?>
            <tr>
              <th scope="row"><?php echo $i++; ?></th>
              <td><?php echo $a['namabank']; ?></td>
              <td><?php echo $a['norek'];?></td>
              <td><?php echo $a['namapenerima'];?></td>
              <?php
              $nono = $a['no'];
              $eaaa = mysql_query("SELECT status FROM selesai WHERE waktu='$waktu' AND no='$nono'");
              $eano = mysql_fetch_assoc($eaaa);
              ?>
              <td><?php echo $eano['status'];?></td>
              <td><?php echo 'Rp. ' . number_format( $a['jumlah'], 0 , '' , ',' ); ?></td>
              <td><?php echo $a['tglcair'];?></td>
              <td><?php echo $a['status'];?></td>
              <td><?php echo $a['persetujuan'];?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        </div><!-- /.table-responsive -->
      </div>


      <!-- Yang belum Bayar BPU-->
              <?php
              $query3="SELECT sum(jumlah) AS sumjum FROM bpu WHERE waktu='$waktu' AND status='Belum Di Bayar'";
              $result3=mysql_query($query3);
              $row3=mysql_fetch_array($result3);
              ?>
              <p><h4><b>Total BPU : <?php echo 'Rp. ' . number_format( $row3['sumjum'], 0 , '' , ',' ); ?></b></h4></p>
      <!-- // Yang belum bayar BPU-->

</div>

</div><!-- //Tab -->

</div>

<div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Bayar Budget</h4>
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
                    <h4 class="modal-title">Pembayaran Memo</h4>
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
                      <h4 class="modal-title">Pembayaran BPU Eksternal</h4>
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

      <div class="modal fade" id="myModal4" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Realisasi</h4>
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


  <?php
    $noid = isset($_GET['no']) && $_GET['no'] ? $_GET['no'] : NULL;
    $waktu = isset($_GET['waktu']) && $_GET['waktu'] ? $_GET['waktu'] : NULL;
  ?>

      <script type="text/javascript">
        function edit_budget(no,waktu){
          // alert(noid+' - '+waktu);
          $.ajax({
              type : 'post',
              url : 'bayarbudget.php',
              data :  {no:no, waktu:waktu},
              success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                $('#myModal').modal();
              }
          });
        }

        function eksternal_finance(no,waktu){
          // alert(noid+' - '+waktu);
          $.ajax({
              type : 'post',
              url : 'financeeksternal.php',
              data :  {no:no, waktu:waktu},
              success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                $('#myModal3').modal();
              }
          });
        }

        function realisasi(no,waktu,term){
          // alert(noid+' - '+waktu);
          $.ajax({
              type : 'post',
              url  : 'realisasi.php',
              data :  {no:no, waktu:waktu, term:term},
              success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                $('#myModal4').modal();
              }
          });
        }

        function bayarmemo(no,waktu){
          // alert(noid+' - '+waktu);
          $.ajax({
              type : 'post',
              url : 'bayarmemo.php',
              data :  {no:no, waktu:waktu},
              success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                $('#myModal2').modal();
              }
          });
        }
      </script>

</body>
</html>
