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

    session_start();
    if(!isset($_SESSION['nama_user'])){
      header("location:login.php");
        // die('location:login.php');//jika belum login jangan lanjut
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

        <script type="text/javascript">
    function validateForm()
    {
        var a=document.forms["Form"]["jumlah"].value;
        var b=document.forms["Form"]["tglcair"].value;
        var c=document.forms["Form"]["namabank"].value;
        var d=document.forms["Form"]["norek"].value;
        var e=document.forms["Form"]["namapenerima"].value;
        if (a==null || a=="",b==null || b=="",c==null || c=="",d==null || d=="",e==null || e=="")
        {
            alert("Harap Isi Yang Kosong");
            return false;
        }
    }
</script>

<?php
$sql2 = "SELECT * FROM bpu WHERE no = '$id' AND waktu = '$waktu' AND persetujuan='Belum Disetujui'";
$result2 = $koneksi->query($sql2);
foreach ($result2 as $baris2) {
?>
        <ul class="list-group">
          <li class="list-group-item">Bank : <b><?php echo $baris2['namabank']; ?></b></li>
          <li class="list-group-item">NO Rekening : <b><?php echo $baris2['norek']; ?></b></li>
          <li class="list-group-item">Nama Penerima : <b><?php echo $baris2['namapenerima']; ?></b></li>
          <li class="list-group-item">Total BPU (IDR) : <b><?php echo 'Rp. ' . number_format( $baris2['jumlah'], 0 , '' , ',' ); ?></b></li>
          <li class="list-group-item">Pengaju BPU : <b><?php echo $baris2['pengaju']; ?> (<?php echo $baris2['divisi']; ?>)</b></li>
        </ul>
<?php } ?>

        <!-- MEMBUAT FORM -->
        <form action="setujuproses.php" method="post">
            <input type="hidden" name="no" value="<?php echo $baris['no']; ?>">
            <input type="hidden" name="waktu" value="<?php echo $baris['waktu']; ?>">
            <input type="hidden" name="pengaju" value="<?php echo $baris['pengaju']; ?>">
            <input type="hidden" name="divisi" value="<?php echo $baris['divisi']; ?>">
            <input type="hidden" name="persetujuan" value="Sudah Disetujui">
            <p>Apakah anda ingin menyetujui <b>BPU</b> di Nomor <b><?=$baris['no'];?></b>?</p>
              <button class="btn btn-primary" type="submit" name="submit">Setujui</button>
        </form>

        <br/>

        <form action="pendingproses.php" method="POST">
          <input type="hidden" name="no" value="<?php echo $baris['no']; ?>">
          <input type="hidden" name="waktu" value="<?php echo $baris['waktu']; ?>">
          <input type="hidden" name="pengaju" value="<?php echo $baris['pengaju']; ?>">
          <input type="hidden" name="divisi" value="<?php echo $baris['divisi']; ?>">
          <button  class="btn-danger btn" name="pending">Pending</button>
        </form>

      <?php } }
    $koneksi->close();
?>
