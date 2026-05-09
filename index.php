<?php
session_start();
include('./includes/config.inc.php');
include('./includes/db.inc.php');


$keresett = $oldalak['fooldal'];
if (isset($_GET['oldal']) && array_key_exists($_GET['oldal'], $oldalak)) {
    $keresett = $oldalak[$_GET['oldal']];
}

include('./templates/layout.php');
?>