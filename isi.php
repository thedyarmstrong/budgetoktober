<?php

include"koneksi.php";
$page=$_GET['page'];

switch($page)

{
	case "1";
	include "tambahbudget.php";
	break;

  case "2";
	include "konfirm.php";
	break;
}

?>
