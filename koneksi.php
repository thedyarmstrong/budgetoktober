<?php

$host="192.168.15.233";
$user="jayatta";
$pass="bm5092da";
$db="budget";


$koneksi=mysql_connect($host,$user,$pass);
$database=mysql_select_db($db,$koneksi);
$tanggal=date('d-M-y');
/*
if ($koneksi)
{
	echo "berhasil : )";
}else{
	echo "Gagal !";
}
*/
?>
