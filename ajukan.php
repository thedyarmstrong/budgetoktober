<?php
error_reporting(0);
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

    if($_POST['rowid']) {
        $id = $_POST['rowid'];
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
        $sql = "SELECT * FROM pengajuan WHERE noid = $id";
        $result = $koneksi->query($sql);
        foreach ($result as $baris) { ?>

        <!-- MEMBUAT FORM -->

        <form action="ajukanproses.php" method="POST">

        <p>Apakah kamu ingin mengajukan budget ini?</p>

        <input type="hidden" name="status" value="Pending">
        <input type="hidden" name="noid" value="<?php echo $baris['noid'];?>">

        <button class="btn btn-primary" type="submit" name="submit">Ajukan</button>

        </form>

      <?php } }
    $koneksi->close();
?>
