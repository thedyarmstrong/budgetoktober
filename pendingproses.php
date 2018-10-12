<?php
include "koneksi.php";

$no           = $_POST['no'];
$waktu        = $_POST['waktu'];
$divisi       = $_POST['divisi'];

if(isset($_POST['pending'])){

      $selbay = mysql_query("SELECT noid FROM pengajuan WHERE waktu='$waktu'");
      $s = mysql_fetch_assoc($selbay);
      $noid = $s['noid'];

      $selfirst=mysql_query("SELECT MIN(noid) FROM bpu WHERE no='$no' AND waktu='$waktu' AND persetujuan='Belum Disetujui'");
      $selsec = mysql_fetch_assoc($selfirst);
      $numb = $selsec['MIN(noid)'];


      $update = mysql_query("UPDATE bpu SET persetujuan = 'Pending'
                            WHERE no='$no' AND waktu='$waktu' AND persetujuan='Belum Disetujui' AND noid='$numb'");

  }


      if ($update){
        echo "<script language='javascript'>";
        echo "alert('Status BPU Menjadi Pending')";
        echo "</script>";
        echo "<script> document.location.href='views-direksi.php?code=".$noid."'; </script>";
      }else{
        echo "Gagal, Harap Coba Lagi";
      }

?>
?>
