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
        $term = $_POST['term'];



        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
        $sql = "SELECT * FROM bpu WHERE no = '$id' AND waktu = '$waktu' AND term = '$term'";
        $result = $koneksi->query($sql);
        foreach ($result as $baris) {
?>
        <!-- MEMBUAT FORM -->
        <form action="hapusbpuproses.php" method="post">
            <input type="hidden" name="no" value="<?php echo $baris['no']; ?>">
            <input type="hidden" name="waktu" value="<?php echo $baris['waktu']; ?>">
            <input type="hidden" name="term" value="<?php echo $baris['term']; ?>">
            <p>Apakah anda yakin ingin menghapus ini?</p>
              <button class="btn btn-primary" type="submit" name="submit">Hapus</button>
        </form>

      <?php } }
    $koneksi->close();
?>
