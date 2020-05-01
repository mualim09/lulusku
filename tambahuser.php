<?php
include('../config.php');
						$nama = $_POST['nama'];
						$username = $_POST['username'];
						$pass = md5($_POST['pass']);
mysqli_query($GLOBALS["___mysqli_ston"], "insert into tbl_user
	(nama,username,pass)
	values
	('$nama','$username','$pass')
");
echo "<div style='background-color:#000000; text-align:center; padding:5px; color:#fff;'>Data Berhasil dikirim. <a href='index.php?page=user'>Lihat Data Admin.</a></div>";
?>