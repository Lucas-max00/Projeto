<?php
session_start();
session_destroy();
header("Location: ../tela1/index.html");
exit();
?>
