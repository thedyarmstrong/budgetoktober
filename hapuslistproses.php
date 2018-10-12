<?php
//error_reporting(0);
 include ('koneksi.php');

  $noid = $_POST['noid'];


  //periksa apakah udah submit
  if (isset($_POST['submit']))
  {

      $update=mysql_query("UPDATE pengajuan SET status = 'Dihapus' WHERE noid ='$noid'");

      //jika sudah berhasil
      if ($update){
        echo "<script language='javascript'>";
        echo "alert('Budget Telah Di Hapus !!')";
        echo "</script>";
        echo "<script> document.location.href='list-direksi.php'; </script>";
      }else{
        echo "Edit Budget Gagal";
      }
    }
?>
