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

    if($_POST['waktu'] && $_POST['noid']) {
        $waktu = $_POST['waktu'];
        $noid  = $_POST['noid'];


        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
        $sql = "SELECT * FROM pengajuan WHERE noid = '$noid' AND waktu = '$waktu'";
        $result = $koneksi->query($sql);
        foreach ($result as $baris) {

        ?>

        <!-- MEMBUAT FORM -->
        <form action="tambahpengajuproses.php" method="post">
            <input type="hidden" name="no" value="<?php echo $baris['noid']; ?>">
            <input type="hidden" name="waktu" value="<?php echo $baris['waktu']; ?>">
            <input type="hidden" name="pengaju" value="<?php echo $_SESSION['nama_user']; ?>">
            <input type="hidden" name="divisi" value="<?php echo $_SESSION['divisi']; ?>">

            <div class="form-group">
              <label for="rincian" class="control-label">Rincian & Keterangan :</label>
                <input type="text" class="form-control" id="rincian" name="rincian">
            </div>

            <div class="form-group">
              <label for="kota" class="control-label">Kota :</label>
                <input type="text" class="form-control" id="kota" name="kota">
            </div>

            <div class="form-group">
              <label for="status">Status :</label>
              <select class="form-control" id="status" name="status">
                <option selected disabled>Pilih Status</option>
                <option value="UM">UM</option>
                <option value="Vendor/Supplier">Vendor / Supplier</option>
                <option value="Honor Eksternal">Honor Eksternal</option>
                <option value="Biaya Lumpsum">Biaya Lumpsum Operational</option>
              </select>
            </div>

            <div class="form-group">
              <label for="penerima" class="control-label">Penerima :</label>
                <input type="text" class="form-control" id="penerima" name="penerima">
            </div>

            <div class="form-group">
              <label for="harga" class="control-label">Harga (IDR) :</label>
                <input type="text" class="form-control" id="harga" value="" name="harga" onkeyup="sum();">
            </div>

            <div class="form-group">
              <label for="quantity" class="control-label">Quantity :</label>
                <input type="text" class="form-control" id="quantity" value="" name="quantity" onkeyup="sum();">
            </div>

            <div class="form-group">
              <label for="total">Total Harga (IDR) :</label>
              <input type="number" class="form-control" id="total" name="total" onkeyup="sum();" value="">
            </div>

              <button class="btn btn-primary" type="submit" name="submit">Update</button>

        </form>

      <?php } }
    $koneksi->close();
?>


<script>
function sum() {
      var txtSecondNumberValue = document.getElementById('harga').value;
      var txtTigaNumberValue = document.getElementById('quantity').value;
      var result = parseFloat(txtSecondNumberValue) * parseFloat(txtTigaNumberValue);
      if (!isNaN(result)) {
         document.getElementById('total').value = result;
      }
}
</script>
