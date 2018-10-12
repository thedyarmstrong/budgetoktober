<?php
//error_reporting(0);
 include ('koneksi.php');

  $no     = $_POST['no'];
  $waktu  = $_POST['waktu'];


  //periksa apakah udah submit
  if (isset($_POST['submit']))
  {

      $update=mysql_query("DELETE FROM selesai WHERE no ='$no' AND waktu ='$waktu'");

      $sel1 = mysql_query("SELECT noid FROM pengajuan WHERE waktu='$waktu'");
      $uc = mysql_fetch_assoc($sel1);
      $numb = $uc['noid'];

      //jika sudah berhasil
      if ($update){
        echo "<script language='javascript'>";
        echo "alert('Item Budget Telah Di Hapus')";
        echo "</script>";
        echo "<script> document.location.href='views-direksi.php?code=".$numb."'; </script>";
      }else{
        echo "Edit Budget Gagal";
      }
    }

?>
