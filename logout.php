<?php
session_start();

//logout, click on previous in browser still let us logged out
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

session_unset();
session_destroy();

header("Location: login.php");
exit();
?>