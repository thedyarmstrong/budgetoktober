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
        $sql = "SELECT * FROM selesai WHERE no ='$id' AND waktu ='$waktu'";
        $result = $koneksi->query($sql);
        foreach ($result as $baris) {

        ?>

        <!-- MEMBUAT FORM -->
        <form action="uploadproses.php" method="post" enctype="multipart/form-data">

        <input type="hidden" name="no" value="<?php echo $baris['no']; ?>">
        <input type="hidden" name="waktu" value="<?php echo $baris['waktu']; ?>">
        <input type="hidden" name="pengaju" value="<?php echo $_SESSION['nama_user'];?>">
        <input type="hidden" name="divisi" value="<?php echo $_SESSION['divisi'];?>">

        <div class="form-group">
          <label for="jumlah">Gambar Memo :</label>
          <input type="file" class="form-control" id="jumlah" name="gambar" accept="image/jpeg,image/x-png,image/gif">
        </div>

          <button class="btn btn-primary" type="submit" name="submit">SUBMIT</button>
        </form>

      <?php } }
    $koneksi->close();
?>
