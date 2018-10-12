<?php
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

    if($_POST['no'] && $_POST['waktu'] && $_POST['term']) {
        $id = $_POST['no'];
        $waktu = $_POST['waktu'];
        $termreal = $_POST['term'];


        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
        $sql = "SELECT * FROM bpu WHERE no = '$id' AND waktu = '$waktu' AND term = '$termreal'";
        $result = $koneksi->query($sql);
        foreach ($result as $baris) {


        if ($baris['status'] =='Telah Di Bayar'){
          echo "BPU Belum Di Realisasi";
        }

        else{

        ?>

        <!-- MEMBUAT FORM -->
        <form action="realisasiproses.php" method="post" name="Form" onsubmit="return validateForm()">

            <input type="hidden" name="no" value="<?php echo $baris['no']; ?>">
            <input type="hidden" name="waktu" value="<?php echo $baris['waktu']; ?>">
            <input type="hidden" name="term" value="<?php echo $baris['term']; ?>">
            <input type="hidden" name="pengaju" value="<?php echo $baris['pengaju']; ?>">
            <input type="hidden" name="divisi" value="<?php echo $baris['divisi']; ?>">
            <input type="hidden" name="status" value="Realisasi (Finance)">


            <div class="form-group">
              <label for="realisasi" class="control-label">Total Realisasi (IDR) :</label>
                <input type="number" class="form-control" id="realisasi" name="realisasi" value="<?php echo $baris['realisasi'] ?>" readonly>
            </div>

            <div class="form-group">
              <label for="uangkembali" class="control-label">Uang Kembali (IDR) :</label>
                <input type="number" class="form-control" id="b" name="uangkembali">
            </div>

            <div class="form-group">
              <label for="tanggalrealisasi" class="control-label">Tanggal Transfer :</label>
                <input type="date" class="form-control" id="c" name="tanggalrealisasi">
            </div>


              <button class="btn btn-primary" type="submit" name="submit">SUBMIT</button>

        </form>

      <?php } } }
    $koneksi->close();
?>
