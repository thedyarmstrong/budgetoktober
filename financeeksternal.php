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

        $sql1 = "SELECT MIN(term) FROM bpu WHERE no ='$id' AND waktu ='$waktu' AND status ='Belum Di Bayar'";
        $result1 = $koneksi->query($sql1);
        foreach ($result1 as $baris1){
        $minterm = $baris1['MIN(term)'];

        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
        $sql = "SELECT * FROM bpu WHERE no ='$id' AND waktu ='$waktu' AND status='Belum Di Bayar' AND term ='$minterm'";
        $result = $koneksi->query($sql);
        foreach ($result as $baris) {

        ?>

        <!-- MEMBUAT FORM -->
        <form action="financeeksternalproses.php" method="post">

        <input type="hidden" name="no" value="<?php echo $baris['no']; ?>">
        <input type="hidden" name="waktu" value="<?php echo $baris['waktu']; ?>">
        <input type="hidden" name="pembayar" value="<?php echo $_SESSION['nama_user'];?>">
        <input type="hidden" name="divisi" value="<?php echo $_SESSION['divisi'];?>">
        <input type="hidden" name="minterm" value="<?php echo $minterm; ?>">

        <?php
        $jumlah = $baris['jumlah'];
         ?>

        <div class="form-group">
          <label for="jumlah">Nama Bank :</label>
          <input type="text" class="form-control" id="namabank" name="namabank" value="<?php echo $baris['namabank']; ?>">
        </div>

        <div class="form-group">
          <label for="jumlah">Nomor Rekening :</label>
          <input type="number" class="form-control" id="norek" name="norek" value="<?php echo $baris['norek']; ?>">
        </div>

        <div class="form-group">
          <label for="jumlah">Nama Penerima :</label>
          <input type="text" class="form-control" id="namapenerima" name="namapenerima" value="<?php echo $baris['namapenerima']; ?>">
        </div>

        <div class="form-group">
          <label for="jumlah">Total BPU (IDR) :</label>
          <input type="number" class="form-control" id="jumlah" name="jumlahbayar" value="<?php echo $jumlah ?>" readonly>
        </div>

        <div class="form-group">
          <label for="nomorvoucher">Nomor Voucher :</label>
          <input type="text" class="form-control" id="nomorvoucher" name="nomorvoucher">
        </div>

        <div class="form-group">
          <label for="tanggal">Tanggal Pembayaran:</label>
          <input type="date" class="form-control" id="tanggal" name="tanggalbayar">
        </div>

          <button class="btn btn-primary" type="submit" name="submit">Bayar</button>
        </form>

      <?php } } }
    $koneksi->close();
?>
