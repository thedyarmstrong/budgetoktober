<?php

include"koneksi.php";
$page=$_GET['page'];

switch($page)

{

	case "1";
	include "printbpu.php";
	break;

	case "2";
	include "printmemorial.php";
	break;

}

?>
