<?php
$servername = "192.168.15.233";
$username = "jayatta";
$password = "bm5092da";
$dbname = "budget";

session_start();
if(!isset($_SESSION['nama_user'])){
  header("location:login.php");
    // die('location:login.php');//jika belum login jangan lanjut
}

    // membuat koneksi
    $koneksi = new mysqli($servername, $username, $password, $dbname);

    // melakukan pengecekan koneksi
    if ($koneksi->connect_error) {
        die("Connection failed: " . $koneksi->connect_error);
    }

    if($_POST['no'] && $_POST['waktu']) {
        $id = $_POST['no'];
        $waktu = $_POST['waktu'];
        $tanggal = date("Y-m-d");


        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
        $sql = "SELECT * FROM selesai WHERE no = '$id' AND waktu = '$waktu'";
        $result = $koneksi->query($sql);
        foreach ($result as $baris) {

        ?>

        <!-- MEMBUAT FORM -->
        <form action="eksternalproses.php" method="post" name="Form" onsubmit="return validateForm()">

            <input type="hidden" name="no" value="<?php echo $baris['no']; ?>">
            <input type="hidden" name="waktu" value="<?php echo $baris['waktu']; ?>">
            <input type="hidden" name="pengaju" value="<?php echo $_SESSION['nama_user']; ?>">
            <input type="hidden" name="divisi" value="<?php echo $_SESSION['divisi']; ?>">

            <div class="form-group">
              <label for="rincian" class="control-label">Total BPU (IDR) :</label>
                <input type="text" class="form-control" id="a" name="jumlah">
            </div>

            <div class="form-group">
              <label for="tglcair" class="control-label">Tanggal Permintaan Pencairan :</label>
                <input type="date" class="form-control" id="b" name="tglcair">
            </div>

            <div class="form-group">
              <label for="namabank" class="control-label">Nama Bank :</label>
                <input type="text" class="form-control" id="c" name="namabank">
            </div>

            <div class="form-group">
              <label for="norek" class="control-label">Nomor Rekening :</label>
                <input type="number" class="form-control" id="d" name="norek">
            </div>

            <div class="form-group">
              <label for="namapenerima" class="control-label">Nama Penerima :</label>
                <input type="text" class="form-control" id="e" name="namapenerima">
            </div>



              <button class="btn btn-primary" type="submit" name="submit">OK</button>

        </form>

      <?php } }
    $koneksi->close();
?>
