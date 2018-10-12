<?php
//error_reporting(0);
 include ('koneksi.php');

  $no     = $_POST['no'];
  $waktu  = $_POST['waktu'];
  $term   = $_POST['term'];


  //periksa apakah udah submit
  if (isset($_POST['submit']))
  {

      $update=mysql_query("DELETE FROM bpu WHERE no ='$no' AND waktu ='$waktu' AND term ='$term'");

      $sel1 = mysql_query("SELECT noid FROM pengajuan WHERE waktu='$waktu'");
      $uc = mysql_fetch_assoc($sel1);
      $numb = $uc['noid'];

      //jika sudah berhasil
      if ($update){
        echo "<script language='javascript'>";
        echo "alert('BPU Berhasil Di Hapus !!')";
        echo "</script>";
        echo "<script> document.location.href='views-direksi.php?code=".$numb."'; </script>";
      }else{
        echo "Edit Budget Gagal";
      }
    }

?>
