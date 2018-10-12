<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['nama_user'])){
  header("location:login.php");
    // die('location:login.php');//jika belum login jangan lanjut
}


    $servername = "192.168.15.233";
    $username = "jayatta";
    $password = "bm5092da";
    $dbname = "budget";

    // membuat koneksi
    $koneksi = new mysqli($servername, $username, $password, $dbname);

    // melakukan pengecekan koneksi
    if ($koneksi->connect_error) {
        die("Connection failed: " . $koneksi->connect_error);
    }

    if($_POST['no'] && $_POST['waktu']) {
        $id = $_POST['no'];
        $waktu = $_POST['waktu'];


        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
        $sql = "SELECT * FROM bpu WHERE waktu ='$waktu' AND status='Belum Di Bayar'";
        $result = $koneksi->query($sql);
        foreach ($result as $baris) {

        ?>

        <!-- MEMBUAT FORM -->
        <ul class="list-group">
          <li class="list-group-item">Bank : <?php echo $baris['namabank']; ?></li>
          <li class="list-group-item">NO Rekening : <?php echo $baris['norek']; ?></li>
          <li class="list-group-item">Nama Penerima : <?php echo $baris['namapenerima']; ?></li>
        </ul>

      <?php } }
    $koneksi->close();
?>
