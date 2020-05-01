<?php
include "../config.php";
$hapus=mysqli_query($GLOBALS["___mysqli_ston"], "delete FROM tbl_siswa");
if($hapus)
{echo "<div align='center'> <h3>Data Telah Terhapus Semua</h3></div>";}
else
{echo "<div align='center'> <h3>Data Gagal Terhapus</h3></div>";}
echo "<meta http-equiv='refresh' content='2; url=index.php?page=data-siswa'>";
?>

