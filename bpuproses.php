<?php
//error_reporting(0);
 include ('koneksi.php');

 error_reporting(0);
 session_start();
 if(!isset($_SESSION['nama_user'])){
   header("location:login.php");
     // die('location:login.php');//jika belum login jangan lanjut
 }

  $no           = $_POST['no'];
  $jumlah       = $_POST['jumlah'];
  $tglcair      = $_POST['tglcair'];
  $namabank     = $_POST['namabank'];
  $norek        = $_POST['norek'];
  $namapenerima = $_POST['namapenerima'];
  $pengaju      = $_POST['pengaju'];
  $divisi       = $_POST['divisi'];
  $waktu        = $_POST['waktu'];

  //periksa apakah udah submit
  if (isset($_POST['submit']))
  {

    $sel1 = mysql_query("SELECT noid FROM pengajuan WHERE waktu='$waktu'");
    $uc = mysql_fetch_assoc($sel1);
    $numb = $uc['noid'];

    $pilihtotal = mysql_query("SELECT total FROM selesai WHERE no='$no' AND waktu='$waktu'");
    $aw = mysql_fetch_assoc($pilihtotal);
    $hargaah = $aw['total'];
    $query="SELECT sum(jumlah) AS sum FROM bpu WHERE no='$no' AND waktu='$waktu'";
    $result=mysql_query($query);
    $row=mysql_fetch_array($result);
    $total=$row[0];
    $query2="SELECT sum(realisasi) AS sum FROM bpu WHERE no='$no' AND waktu='$waktu'";
    $result2=mysql_query($query2);
    $row2=mysql_fetch_array($result2);
    $total2=$row2[0];
    $cobadulutot = $total - $total2;
    $jadinya = $hargaah - $cobadulutot;

    $caribayar = mysql_query("SELECT status FROM bpu WHERE waktu='$waktu' AND no='$no' AND status='Belum Di Bayar'");

    $carieksternal = mysql_query("SELECT status FROM selesai WHERE waktu='$waktu' AND no='$no' AND status='Vendor/Supplier'");

      if ($jumlah > $jadinya){
        echo "<script language='javascript'>";
        echo "alert('GAGAL!!, Kamu tidak bisa mengajuakan lebih dari sisa Pembayaran')";
        echo "</script>";
        echo "<script> document.location.href='views.php?code=".$numb."'; </script>";
      }

      else if(mysql_num_rows($caribayar)>0) {
        echo "<script language='javascript'>";
        echo "alert('GAGAL!!, Ada BPU yang masih Belum Di Bayar')";
        echo "</script>";
        echo "<script> document.location.href='views.php?code=".$numb."'; </script>";
      }

      else if(mysql_num_rows($carieksternal)>0){
        echo "<script language='javascript'>";
        echo "alert('GAGAL!!, Untuk BPU Eksternal Harap langsung ajukan dokumen terkait Ke Ibu Ina Puspito')";
        echo "</script>";
        echo "<script> document.location.href='views.php?code=".$numb."'; </script>";
      }

      else{
      $selterm = mysql_query("SELECT MAX(term) FROM bpu WHERE no='$no' AND waktu='$waktu'");
      $m = mysql_fetch_assoc($selterm);
      $termterm = $m['MAX(term)'];
      $termfinal = $termterm + 1;

      $insert = mysql_query("INSERT INTO bpu (no,jumlah,tglcair,namabank,norek,namapenerima,pengaju,divisi,waktu,status,persetujuan,term) VALUES
                                            ('$no','$jumlah','$tglcair','$namabank','$norek','$namapenerima','$pengaju','$divisi','$waktu','Belum Di Bayar','Belum Disetujui','$termfinal')");

      }

      if ($insert){
        if($divisi == 'FINANCE'){
          if ($_SESSION['nama_user'] == 'SRI DEWI MARPAUNG'){
          echo "<script language='javascript'>";
          echo "alert('Pembuatan BPU Berhasil')";
          echo "</script>";
          echo "<script> document.location.href='view-finance-manager.php?code=".$numb."'; </script>";
          }else if ($_SESSION['nama_user'] == 'Melinda Fatmawati'){
            echo "<script language='javascript'>";
            echo "alert('Pembuatan BPU Berhasil')";
            echo "</script>";
            echo "<script> document.location.href='view-finance-melinda-b1.php?code=".$numb."'; </script>";
          }
        }else{
        echo "<script language='javascript'>";
        echo "alert('Pembuatan BPU Berhasil')";
        echo "</script>";
        echo "<script> document.location.href='views.php?code=".$numb."'; </script>";
        }
      }else{
        echo "Pembuatan BPU Gagal";
      }
    }

?>
