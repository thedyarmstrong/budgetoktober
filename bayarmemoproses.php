<?php
//error_reporting(0);
 include ('koneksi.php');

  $no           = $_POST['no'];
  $waktu        = $_POST['waktu'];
  $pembayar     = $_POST['pembayar'];
  $divisi       = $_POST['divisi'];


  //periksa apakah udah submit
  if (isset($_POST['submit']))
  {

      $selbay = mysql_query("SELECT noid FROM pengajuan WHERE waktu='$waktu'");
      $s = mysql_fetch_assoc($selbay);
      $noid = $s['noid'];

      $sellagi = mysql_query("SELECT MAX(noid) FROM upload WHERE waktu='$waktu'");
      $sel = mysql_fetch_assoc($sellagi);
      $nomax = $sel['MAX(noid)'];

      $update=mysql_query("UPDATE upload SET status ='Telah Dibayar', pembayar='$pembayar', divpemb='$divisi' WHERE waktu='$waktu' AND no='$no' AND noid='$nomax'");

      }

      if ($update){
        echo "<script language='javascript'>";
        echo "alert('Pembayaran Memo Berhasil')";
        echo "</script>";
        echo "<script> document.location.href='view-finance.php?code=".$noid."'; </script>";
      }else{
        echo "Pembayaran Memo Gagal";
      }


?>
