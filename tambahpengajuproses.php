<?php
 //error_reporting(0);
 include ('koneksi.php');

 if (isset($_POST['submit']))
 {

  $waktu     = $_POST['waktu'];
  $rincian   = $_POST['rincian'];
  $kota      = $_POST['kota'];
  $status    = $_POST['status'];
  $penerima  = $_POST['penerima'];
  $harga     = $_POST['harga'];
  $quantity  = $_POST['quantity'];
  $total     = $_POST['total'];
  $pengaju   = $_POST['pengaju'];
  $divisi    = $_POST['divisi'];

  //periksa apakah udah submit

      $selfirst = mysql_query("SELECT MAX(no) FROM selesai WHERE waktu = '$waktu'");



      $ea = mysql_fetch_assoc($selfirst);
      $nomax = $ea['MAX(no)'] + 1;

      $insertdulu = mysql_query("INSERT INTO selesai (no,rincian,kota,status,penerima,harga,quantity,total,pembayaran,pengaju,divisi,waktu,komentar) VALUES
                                            ('$nomax','$rincian','$kota','$status','$penerima','$harga','$quantity','$total','Belum Dibayar','$pengaju','$divisi','$waktu',NULL)");

        $sel1 = mysql_query("SELECT noid FROM pengajuan WHERE waktu='$waktu'");
        $uc = mysql_fetch_assoc($sel1);
        $numb = $uc['noid'];


      if ($insertdulu){
        echo "<script language='javascript'>";
        echo "alert('Tambah Budget Berhasil')";
        echo "</script>";
        echo "<script> document.location.href='view.php?code=".$numb."'; </script>";
      }else{
        echo "Tambah Budget Gagal";
      }
    }
?>
