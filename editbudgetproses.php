<?php
//error_reporting(0);
 include ('koneksi.php');

  $no       =$_POST['no'];
  $waktu    =$_POST['waktu'];
  $penerima =$_POST['penerima'];
  $harga    =$_POST['harga'];
  $quantity =$_POST['quantity'];
  $total    =$_POST['total'];
  $komentar =$_POST['komentar'];


  //periksa apakah udah submit
  if (isset($_POST['submit']))
  {

      $update=mysql_query("UPDATE selesai SET penerima ='$penerima',
                                              harga ='$harga',
                                              quantity ='$quantity',
                                              total ='$total', komentar ='$komentar' WHERE no='$no' AND waktu='$waktu'");

      //jika sudah berhasil
      if ($update){

        $result = mysql_query("SELECT SUM(total) AS value_sum FROM selesai WHERE waktu ='$waktu'");
        $row = mysql_fetch_assoc($result);
        $sum = $row['value_sum'];

        $updatetotal=mysql_query("UPDATE pengajuan SET totalbudget ='$sum' WHERE waktu='$waktu'");

          $sel1 = mysql_query("SELECT noid FROM pengajuan WHERE waktu='$waktu'");
          $uc = mysql_fetch_assoc($sel1);
          $numb = $uc['noid'];
          echo "<script language='javascript'>";
          echo "alert('Edit Budget Berhasil')";
          echo "</script>";
          echo "<script> document.location.href='view-direksi.php?code=".$numb."'; </script>";
        }
        else{
          echo "Edit Budget Gagal";
        }
      }
?>
