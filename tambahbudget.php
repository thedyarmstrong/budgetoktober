<form class="form-horizontal" action="proses/proses-tambahbudget.php" method="POST">

  <div class="form-group">
    <label for="jenis">Jenis Project :</label>
    <select class="form-control" id="jenis" name="jenis" required>
      <option disabled selected>Pilih Jenis Project</option>
      <option value="B1">B1</option>
      <option value="B2">B2</option>
      <option value="Rutin">Non Project Umum (Rutin)</option>
      <option value="Non Rutin">Non Project Umum (Non Rutin)</option>
    </select>
  </div>

  <div class="form-group">
    <label for="email">Nama Project :</label>
    <input type="text" class="form-control" id="email" name="nama" required>
  </div>

  <div class="form-group">
    <label for="email">Tahun :</label>
    <select class="form-control" id="email" name="tahun" required>
      <option disabled selected>Pilih Tahun</option>
      <?php
       for($i = 2017 ; $i <= 2030; $i++){
          echo "<option>$i</option>";
       }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="email">Pengaju Budget :</label>
    <input type="text" class="form-control" placeholder="<?php echo $_SESSION['nama_user']; ?> (<?php echo $_SESSION['divisi']; ?>)" disabled>
  </div>


    <input type="hidden" class="form-control" id="pwd" name="pengaju" value="<?php echo $_SESSION['nama_user']; ?>">

    <input type="hidden" class="form-control" id="pwd" name="divisi" value="<?php echo $_SESSION['divisi']; ?>">

    <input type="hidden" class="form-control" id="pwd" name="status" value="Belum Di Ajukan">



  <div class="form-group">
    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
  </form>
