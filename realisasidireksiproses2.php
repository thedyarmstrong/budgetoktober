<?php
//error_reporting(0);
 include ('koneksi.php');

  $no               = $_POST['no'];
  $waktu            = $_POST['waktu'];
  $tanggalrealisasi = $_POST['tanggalrealisasi'];
  $status           = $_POST['status'];
  $totalbpu         = $_POST['totalbpu'];
  $totalrealisasi   = $_POST['totalrealisasi'];
  $uangkembali      = $_POST['uangkembali'];

  //periksa apakah udah submit
  if (isset($_POST['submit']))
  {

      $selnumb = mysql_query("SELECT noid FROM pengajuan WHERE waktu='$waktu'");
      $sn = mysql_fetch_assoc($selnumb);
      $numb = $sn['noid'];
      $kembreal = $totalrealisasi + $uangkembali;

      if($totalrealisasi > $totalbpu){
        echo "<script language='javascript'>";
        echo "alert('Gagal!! Total Realiasi tidak bisa lebih besar dari Total BPU')";
        echo "</script>";
        echo "<script> document.location.href='views-direksi.php?code=".$numb."'; </script>";
      }
      else if ($kembreal > $totalbpu){
        echo "<script language='javascript'>";
        echo "alert('Gagal!! Total Realiasi dan Uang Kembali tidak bisa lebih besar dari Total BPU')";
        echo "</script>";
        echo "<script> document.location.href='views-direksi.php?code=".$numb."'; </script>";
      }

      else{
        $term_arr = $_POST['term'];
        $count = count($term_arr);
        $bagireal = $totalrealisasi / $count;
        $bagikemb = $uangkembali / $count;

        if(gettype($_POST['term'])=="array"){

        foreach($_POST['term'] as $val){

         $id_c=$val;

         $update = mysql_query("UPDATE bpu SET realisasi='$bagireal' , uangkembali='$bagikemb', status='$status'
                                WHERE no='$no' AND waktu='$waktu' AND term='$id_c'");
        }
        }
      }
  }
?>
