<?php
//error_reporting(0);
 include ('koneksi.php');

 session_start();
 if(!isset($_SESSION['nama_user'])){
   header("location:login.php");
     // die('location:login.php');//jika belum login jangan lanjut
 }

  $no           = $_POST['no'];
  $jumlah       = $_POST['jumlah'];
  $waktu        = $_POST['waktu'];
  $tglcair      = $_POST['tglcair'];
  $pengaju      = $_POST['pengaju'];
  $divisi       = $_POST['divisi'];
  $namabank     = $_POST['namabank'];
  $norek        = $_POST['norek'];
  $namapenerima = $_POST['namapenerima'];


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
    $jadinya = $hargaah - $total;

    $caribayar = mysql_query("SELECT status FROM bpu WHERE waktu='$waktu' AND no='$no' AND status='Belum Di Bayar'");



      if ($jumlah > $jadinya){
        echo "<script language='javascript'>";
        echo "alert('GAGAL!!, Tidak bisa mengajukan lebih dari sisa Pembayaran')";
        echo "</script>";
        echo "<script> document.location.href='views-direksi.php?code=".$numb."'; </script>";
      }

      // else if(mysql_num_rows($caribayar)>0) {
      //   echo "<script language='javascript'>";
      //   echo "alert('GAGAL!!, Ada BPU yang masih Belum Di Bayar')";
      //   echo "</script>";
      //   echo "<script> document.location.href='views-direksi.php?code=".$numb."'; </script>";
      // }

      else{
      $selterm = mysql_query("SELECT MAX(term) FROM bpu WHERE no='$no' AND waktu='$waktu'");
      $m = mysql_fetch_assoc($selterm);
      $termterm = $m['MAX(term)'];
      $termfinal = $termterm + 1;

      $insert = mysql_query("INSERT INTO bpu (no,jumlah,tglcair,namabank,norek,namapenerima,pengaju,divisi,waktu,status,persetujuan,term) VALUES
                                            ('$no','$jumlah','$tglcair','$namabank','$norek','$namapenerima','$pengaju','$divisi','$waktu','Belum Di Bayar','Disetujui (Direksi)','$termfinal')");

      }

      if ($insert){

        if ($divisi == 'FINANCE'){
          echo "<script language='javascript'>";
          echo "alert('Pembuatan BPU Eksternal Berhasil!!')";
          echo "</script>";
          echo "<script> document.location.href='view-finance-manager.php?code=".$numb."'; </script>";
        }
        else{
          echo "<script language='javascript'>";
          echo "alert('Pembuatan BPU Eksternal Berhasil!!')";
          echo "</script>";
          echo "<script> document.location.href='views-direksi.php?code=".$numb."'; </script>";
        }
      }else{
        echo "Pembuatan Budget External Gagal";
      }
    }

?>
