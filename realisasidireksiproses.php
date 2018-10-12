<?php
//error_reporting(0);
 include ('koneksi.php');

  $no               = $_POST['no'];
  $waktu            = $_POST['waktu'];
  $term             = $_POST['term'];
  $realisasi        = $_POST['realisasi'];
  $uangkembali      = $_POST['uangkembali'];
  $tanggalrealisasi = $_POST['tanggalrealisasi'];
  $status           = $_POST['status'];


  //periksa apakah udah submit
  if (isset($_POST['submit']))
  {

      $cekreal = mysql_query("SELECT * FROM bpu WHERE no='$no' AND waktu='$waktu' AND term='$term'");
      $sr = mysql_fetch_assoc($cekreal);
      $stt = $sr['status'];
      $jb = $sr['jumlahbayar'];
      $sel1 = mysql_query("SELECT noid FROM pengajuan WHERE waktu='$waktu'");
      $uc = mysql_fetch_assoc($sel1);
      $numb = $uc['noid'];


      if ($stt == 'Realisasi (Direksi)' OR $stt == 'Realisasi (Finance)'){
        echo "<script language='javascript'>";
        echo "alert('Gagal!! BPU sudah di realiasisai. Tidak bisa Realisasi dua kali')";
        echo "</script>";
        echo "<script> document.location.href='views-direksi.php?code=".$numb."'; </script>";
      }

      else if ($stt == 'Belum Di Bayar'){
        echo "<script language='javascript'>";
        echo "alert('Gagal!! BPU belum di Bayar !!')";
        echo "</script>";
        echo "<script> document.location.href='views-direksi.php?code=".$numb."'; </script>";
      }

      else if ($realisasi > $jb){
        echo "<script language='javascript'>";
        echo "alert('Gagal!! Realisasi Lebih Besar Dari Jumlah Pembayaran !!')";
        echo "</script>";
        echo "<script> document.location.href='views-direksi.php?code=".$numb."'; </script>";
      }

      else {
          $update=mysql_query("UPDATE bpu SET realisasi ='$realisasi', uangkembali ='$uangkembali',
                                              tanggalrealisasi ='$tanggalrealisasi',
                                              status ='$status' WHERE no='$no' AND waktu='$waktu' AND term='$term'");

          //jika sudah berhasil
          if ($update){
              echo "<script language='javascript'>";
              echo "alert('Realisasi Budget Berhasil')";
              echo "</script>";
              echo "<script> document.location.href='views-direksi.php?code=".$numb."'; </script>";
            }
      }
  }
?>
