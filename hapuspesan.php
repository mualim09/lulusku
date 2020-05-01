<?php
include('../config.php');
mysqli_query($GLOBALS["___mysqli_ston"], "delete from tbl_hubungi where id_hubungi='$_POST[id]'");
?>