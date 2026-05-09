<?php
try {
    $dbh = new PDO('mysql:host=localhost;dbname=baliaki', 'baliaki', 'baliaki',
                    array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
}
catch (PDOException $e) {
    echo "Hiba: ".$e->getMessage();
}
?>
