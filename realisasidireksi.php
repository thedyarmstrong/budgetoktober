<?php
$servername = "192.168.15.233";
$username = "jayatta";
$password = "bm5092da";
$dbname = "budget";

error_reporting(0);
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

        <script>
          // $(document).ready(function(){
          //   $("#total_realisasi").val("aeryhsaetyh");
          // })
          //
          // var $cs   = $('.charge').change(function () {
          //   var total = +$('.total').html().trim() || 0;
          //   var v = $(this).data('cash');
          //   if (this.checked) {
          //     total += v;
          //   } else {
          //       total -= v;
          //   }
          //   $('.total').html(total);
          // });
          //
          // $('.charge:checked').change();

        // window.onload=function(){
        // var inputs = document.getElementsByClassName('sum'),
        //     total  = document.getElementById('payment-total');
        //
        //  for (var i=0; i < inputs.length; i++) {
        //     inputs[i].onchange = function() {
        //         var add = this.value * (this.checked ? 1 : -1);
        //         total.innerHTML = parseFloat(total.innerHTML) + add
        //         var new_total = parseFloat(document.getElementById('input').value);
        //       console.log(new_total);
        //         document.getElementById('input').value=new_total + add
        //     }
        //   }
        // }

        $(document).ready(function(){
        	$(".percobaan").change(function(){
          	var hasil = +$("#hasil").val().trim() || 0;
            var angka = parseInt($(this).data("cash"));
            if(this.checked){
            	hasil += angka;
            }else{
            	hasil -= angka;
            }

            $("#hasil").val(hasil);
          })
        })
        </script>

        <!-- MEMBUAT FORM -->


            <input type="hidden" name="no" value="<?php echo $baris['no']; ?>">
            <input type="hidden" name="waktu" value="<?php echo $baris['waktu']; ?>">
            <input type="hidden" name="tanggalrealisasi" value="<?php echo $tanggal; ?>">
            <input type="hidden" name="status" value="Realisasi (Direksi)">

            <div class="form-group">
              <label for="sel1">Gabungan BPU:</label>
                <?php
                $sql2 = "SELECT term,jumlahbayar FROM bpu WHERE no = '$id' AND waktu = '$waktu' AND status='Telah Di Bayar' ORDER BY term";
                $result2 = $koneksi->query($sql2);
                foreach ($result2 as $baris2) {
                ?>
                <div class="checkbox">
                  <label><input type="checkbox" class="charge percobaan" name="term[]" data-cash="<?php echo $baris2['jumlahbayar']; ?>" value="<?php echo $baris2['term']; ?>">Term <?php echo $baris2['term']; ?></label>
                </div>
                <?php
                }
                ?>
            </div>

            <p id="test"></p>



        </form>

      <?php }}

    $koneksi->close();
?>
