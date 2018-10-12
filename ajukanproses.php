<?php
//error_reporting(0);
 include ('koneksi.php');

  $noid   = $_POST['noid'];
  $status = $_POST['status'];

  //periksa apakah udah submit
  if (isset($_POST['submit']))
  {


      $update = mysql_query("UPDATE pengajuan SET status='$status' WHERE noid='$noid'");

      //jika sudah berhasil


    if ($update)
    {
          echo $panjang;
          echo "<script language='javascript'>";
          echo "alert('Pengajuan Telah Di Ajukan, Status Berubah Menjadi PENDING')";
          echo "</script>";
          echo "<script> document.location.href='list.php'; </script>";
    }
  }

?>
