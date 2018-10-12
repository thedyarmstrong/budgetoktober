<?php
//error_reporting(0);
 include ('koneksi.php');

 session_start();
 if(!isset($_SESSION['nama_user'])){
   header("location:login.php");
     // die('location:login.php');//jika belum login jangan lanjut
 }

  $no           = $_POST['no'];
  $waktu        = $_POST['waktu'];
  $divisi       = $_POST['divisi'];
  $persetujuan  = $_POST['persetujuan'];
  $finance      = $_SESSION['divisi'];


  //periksa apakah udah submit
  if (isset($_POST['submit']))
  {

      $selbay = mysql_query("SELECT noid FROM pengajuan WHERE waktu='$waktu'");
      $s = mysql_fetch_assoc($selbay);
      $noid = $s['noid'];

      $selfirst=mysql_query("SELECT MIN(noid) FROM bpu WHERE no='$no' AND waktu='$waktu' AND persetujuan='Belum Disetujui'");
      $selsec = mysql_fetch_assoc($selfirst);
      $numb = $selsec['MIN(noid)'];


      if($finance == 'FINANCE'){

      $update = mysql_query("UPDATE bpu SET persetujuan = 'Disetujui (Sri Dewi Marpaung)'
                            WHERE no='$no' AND waktu='$waktu' AND persetujuan='Belum Disetujui' AND noid='$numb'");
      }else{
        $update = mysql_query("UPDATE bpu SET persetujuan = 'Disetujui (Direksi)'
                              WHERE no='$no' AND waktu='$waktu' AND persetujuan='Belum Disetujui' AND noid='$numb'");
      }

  }


      if ($update){
        if ($finance == 'FINANCE'){
          echo "<script language='javascript'>";
          echo "alert('BPU Telah Disetujui(Sri Dewi Marpaung)')";
          echo "</script>";
          echo "<script> document.location.href='view-finance-manager.php?code=".$noid."'; </script>";
        }else{
          echo "<script language='javascript'>";
          echo "alert('BPU Telah Disetujui')";
          echo "</script>";
          echo "<script> document.location.href='views-direksi.php?code=".$noid."'; </script>";
        }
      }else{
        echo "Gagal menyetujui BPU";
      }

?>
