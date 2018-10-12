<?php
 //error_reporting(0);
 include ('koneksi.php');

  $noidbpu        = isset($_POST['noidbpu']) != "" ? $_POST['noidbpu'] : "";
  $no             = $_POST['no'];
  $waktu          = $_POST['waktu'];
  $jumlah         = $_POST['jumlah'];
  $realisasi      = $_POST['realisasi'];
  $uangkembali    = $_POST['uangkembali'];
  $namabank       = $_POST['namabank'];
  $namapenerima   = $_POST['namapenerima'];
  $norek          = $_POST['norek'];
  $tglcair        = $_POST['tglcair'];
  $alasan         = $_POST['alasan'];
  $lastedit       = $_POST['lastedit'];
  $term           = $_POST['term'];

  session_start();
  if(!isset($_SESSION['nama_user'])){
    header("location:login.php");
      // die('location:login.php');//jika belum login jangan lanjut
  }

  //periksa apakah udah submit
  if (isset($_POST['submit']))
  {
      $update = mysql_query("UPDATE bpu SET jumlah = '$jumlah', namabank = '$namabank', namapenerima = '$namapenerima', norek = '$norek',
                                            tglcair = '$tglcair', alasan = '$alasan', lastedit = '$lastedit' WHERE no = '$no'
                                            AND waktu = '$waktu' AND term = '$term'");


      //jika sudah berhasil
      if ($update){

          $sel1 = mysql_query("SELECT noid FROM pengajuan WHERE waktu='$waktu'");
          $uc = mysql_fetch_assoc($sel1);
          $numb = $uc['noid'];

          if ($_SESSION['nama_user'] == 'SRI DEWI MARPAUNG'){
          echo "<script language='javascript'>";
          echo "alert('Edit BPU Berhasil')";
          echo "</script>";
          echo "<script> document.location.href='view-finance-manager.php?code=".$numb."'; </script>";
          }
          else
          {
          echo "<script language='javascript'>";
          echo "alert('Edit BPU Berhasil')";
          echo "</script>";
          echo "<script> document.location.href='views-direksi.php?code=".$numb."'; </script>";
          }
      }
    }
?>
