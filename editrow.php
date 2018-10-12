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

    if($_POST['no'] && $_POST['waktu']) {
        $id = $_POST['no'];
        $waktu = $_POST['waktu'];


        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
        $sql = "SELECT * FROM selesai WHERE no = '$id' AND waktu = '$waktu'";
        $result = $koneksi->query($sql);
        foreach ($result as $baris) {

        ?>

        <!-- MEMBUAT FORM -->
        <form action="editrowproses.php" method="post">
            <input type="hidden" name="no" value="<?php echo $baris['no']; ?>">
            <input type="hidden" name="waktu" value="<?php echo $baris['waktu']; ?>">

            <div class="form-group">
              <label for="rincian" class="control-label">Rincian & Keterangan :</label>
                <input type="text" class="form-control" id="rincian" value="<?php echo $baris['rincian']; ?>" name="rincian">
            </div>

            <div class="form-group">
              <label for="kota" class="control-label">Kota :</label>
                <input type="text" class="form-control" id="kota" value="<?php echo $baris['kota']; ?>" name="kota">
            </div>

            <div class="form-group">
              <label for="status">Status :</label>
              <select class="form-control" id="status" name="status">
                <option selected value="<?php echo $baris['status']; ?>"><?php echo $baris['status']; ?></option>
                <option value="UM">UM</option>
                <option value="Vendor/Supplier">Vendor / Supplier</option>
                <option value="Honor Eksternal">Honor Eksternal</option>
                <option value="Biaya Lumpsum">Biaya Lumpsum Operational</option>
              </select>
            </div>

            <div class="form-group">
              <label for="kota" class="control-label">Penerima :</label>
                <input type="text" class="form-control" id="penerima" value="<?php echo $baris['penerima']; ?>" name="penerima">
            </div>

            <div class="form-group">
              <label for="harga" class="control-label">Harga (IDR) :</label>
                <input type="text" class="form-control" id="harga" value="<?php echo $baris['harga']; ?>" name="harga" onkeyup="sum();">
            </div>

            <div class="form-group">
              <label for="quantity" class="control-label">Quantity :</label>
                <input type="text" class="form-control" id="quantity" value="<?php echo $baris['quantity']; ?>" name="quantity" onkeyup="sum();">
            </div>

            <div class="form-group">
              <label for="total">Total Harga (IDR) :</label>
              <input type="number" class="form-control" id="total" name="total" onkeyup="sum();" value="<?php echo $baris['total']; ?>">
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
