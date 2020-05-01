<?php
include('../config.php');
mysqli_query($GLOBALS["___mysqli_ston"], "delete from tbl_user where id_user='$_POST[id]'");
?>