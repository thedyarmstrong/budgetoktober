<?php
//error_reporting(0);
 include ('koneksi.php');

 date_default_timezone_set("Asia/Bangkok");

  $no           = $_POST['no'];
  $waktu        = $_POST['waktu'];
  $pengaju      = $_POST['pengaju'];
  $divisi       = $_POST['divisi'];
  $nama_gambar  = $_FILES['gambar'] ['name'];
  $lokasi       = $_FILES['gambar'] ['tmp_name']; // Menyiapkan tempat nemapung gambar yang diupload
  $lokasitujuan ="./uploads"; // Menguplaod gambar kedalam folder ./image
  $upload       = move_uploaded_file($lokasi,$lokasitujuan."/".$nama_gambar);
  $timestam     = date("Y-m-d h:i:sa");


  //periksa apakah udah submit
  if (isset($_POST['submit']))
  {

    $selbay = mysql_query("SELECT noid FROM pengajuan WHERE waktu='$waktu'");
    $s = mysql_fetch_assoc($selbay);
    $noid = $s['noid'];

    $result = mysql_query("SELECT * FROM upload WHERE waktu='$waktu' AND status='Belum Dibayar' LIMIT 1");
    $num_rows = mysql_num_rows($result);

    if ($num_rows > 0) {
      echo "<script language='javascript'>";
      echo "alert('Upload Gagal!!, Kamu Masih ada Memo Yang Belum Di bayar')";
      echo "</script>";
      echo "<script> document.location.href='view.php?code=".$noid."'; </script>";
    }
    else {

      $bikinbayar=mysql_query("INSERT INTO upload (no,waktu,pengaju,divisi,gambar,status,timestam)
                                          VALUES ('$no','$waktu','$pengaju','$divisi','$nama_gambar','Belum Dibayar','$timestam')");
    }

    if ($bikinbayar){
        echo "<script language='javascript'>";
        echo "alert(Upload Memo Berhasil')";
        echo "</script>";
        echo "<script> document.location.href='view.php?code=".$noid."'; </script>";
      }else{
        echo "Bayar Budget Gagal";
    }
  }

  echo $timestam;
?>
