<?php
$uzenet = "";

if(isset($_POST['regisztracio'])) {
    $sql = "SELECT id FROM felhasznalok WHERE bejelentkezes = :felhasznalo";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':felhasznalo' => $_POST['felhasznalo']));
    
    if($stmt->fetch()) {
        $uzenet = "Hiba: Ez a felhasználónév már foglalt!";
    } else {
        $sql = "INSERT INTO felhasznalok (csaladi_nev, uto_nev, bejelentkezes, jelszo) VALUES (:csaladi_nev, :uto_nev, :bejelentkezes, :jelszo)";
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':csaladi_nev' => $_POST['csaladi_nev'],
            ':uto_nev' => $_POST['uto_nev'],
            ':bejelentkezes' => $_POST['felhasznalo'],
            ':jelszo' => sha1($_POST['jelszo'])
        ));
        $uzenet = "Sikeres regisztráció! Most már bejelentkezhetsz.";
    }
}
?>

<div class="regisztracio-tartalom" style="text-align: center; padding: 20px;">
    <h2>Regisztráció</h2>
    
    <?php if($uzenet): ?>
        <p style="color: #d9534f; font-weight: bold;"><?= $uzenet ?></p>
    <?php endif; ?>

    <form action="index.php?oldal=regisztracio" method="post" style="max-width: 300px; margin: 0 auto; text-align: left;">
        <label>Családi név:</label><br>
        <input type="text" name="csaladi_nev" required style="width: 100%; padding: 5px; margin-bottom: 10px;"><br>
        
        <label>Utónév:</label><br>
        <input type="text" name="uto_nev" required style="width: 100%; padding: 5px; margin-bottom: 10px;"><br>
        
        <label>Felhasználónév:</label><br>
        <input type="text" name="felhasznalo" required style="width: 100%; padding: 5px; margin-bottom: 10px;"><br>
        
        <label>Jelszó:</label><br>
        <input type="password" name="jelszo" required style="width: 100%; padding: 5px; margin-bottom: 15px;"><br>
        
        <input type="submit" name="regisztracio" value="Regisztráció" style="background-color: #004d7a; color: white; padding: 10px 20px; border: none; cursor: pointer; width: 100%;">
    </form>
    
    <p style="margin-top: 20px;">
        Már van fiókod? <a href="index.php?oldal=bejelentkezes">Jelentkezz be itt!</a>
    </p>
</div>