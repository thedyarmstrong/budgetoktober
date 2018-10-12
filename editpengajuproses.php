<?php
//error_reporting(0);
 include ('koneksi.php');

  $no        = $_POST['no'];
  $waktu     = $_POST['waktu'];
  $rincian   = $_POST['rincian'];
  $kota      = $_POST['kota'];
  $status    = $_POST['status'];
  $penerima  = $_POST['penerima'];
  $harga     = $_POST['harga'];
  $quantity  = $_POST['quantity'];
  $total     = $_POST['total'];

  //periksa apakah udah submit
  if (isset($_POST['submit']))
  {

      $update=mysql_query("UPDATE selesai SET rincian = '$rincian', kota = '$kota', status = '$status', penerima = '$penerima', harga = '$harga', quantity = '$quantity',
                                              total= $harga * $quantity WHERE no ='$no' AND waktu='$waktu'");

      //jika sudah berhasil
      if ($update){
        $query="SELECT sum(total) AS sum FROM selesai WHERE waktu='$waktu'";
        $result=mysql_query($query);
        $row=mysql_fetch_array($result);

        $totaljadi = $total=$row[0];

        $updatetotal=mysql_query("UPDATE pengajuan SET totalbudget = $totaljadi WHERE waktu='$waktu'");

        $sel1 = mysql_query("SELECT noid FROM pengajuan WHERE waktu='$waktu'");
        $uc = mysql_fetch_assoc($sel1);
        $numb = $uc['noid'];
      }

      if ($updatetotal){
        echo "<script language='javascript'>";
        echo "alert('Edit Budget Berhasil')";
        echo "</script>";
        echo "<script> document.location.href='view.php?code=".$numb."'; </script>";
      }else{
        echo "Edit Budget Gagal";
      }
    }

?>
