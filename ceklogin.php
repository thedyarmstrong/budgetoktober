<?php
error_reporting(0);
session_start();
include "koneksi.php";
$id_user = $_POST['id_user'];
$password = $_POST['password'];
$op = $_GET['op'];

if($op=="in"){
    $sql = mysql_query("SELECT * FROM tb_user WHERE id_user='$id_user' AND PASSWORD='$password'");

        if(mysql_num_rows($sql)==1){//jika berhasil akan bernilai 1
            $qry = mysql_fetch_array($sql);
            $_SESSION['nama_user'] = $qry['nama_user'];
            $_SESSION['divisi'] = $qry['divisi'];
            $_SESSION['hak_akses'] = $qry['hak_akses'];
            $_SESSION['id_user'] = $qry['id_user'];

                if($qry){
                    if ($qry['divisi'] == "Direksi" || $qry['divisi'] == "Direksi")
                  {
                    header("location:home-direksi.php");
                  }
                    else if ($qry['divisi'] == "FINANCE" || $qry['divisi'] == "FINANCE")
                  {
                    header("location:home-finance.php");
                  }
                  else if ($qry['divisi'] == "Admin" || $qry['divisi'] == "Admin")
                {
                  header("location:home-admin.php");
                }
                  else {
                    header("location:home.php");
                  }
                }

                }else{
                ?>
<script language="JavaScript">
    alert('Username atau Password tidak sesuai. Silahkan diulang kembali!');
    document.location='index.php';
</script>
<?php
}
}else if($op=="out"){
    unset($_SESSION['USERNAME']);
    unset($_SESSION['AKSES']);
    header("location:index.php");
}

?>
