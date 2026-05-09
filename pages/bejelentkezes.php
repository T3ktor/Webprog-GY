<?php
$uzenet = "";
if(isset($_POST['belepes'])) {
    if(isset($_POST['felhasznalo']) && isset($_POST['jelszo'])) {
        $sql = "SELECT id, csaladi_nev, uto_nev, bejelentkezes, jelszo FROM felhasznalok WHERE bejelentkezes = :felhasznalo";
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':felhasznalo' => $_POST['felhasznalo']));
        $felhasznalo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($felhasznalo && sha1($_POST['jelszo']) == $felhasznalo['jelszo']) {
            $_SESSION['login'] = $felhasznalo['bejelentkezes'];
            $_SESSION['csaladi_nev'] = $felhasznalo['csaladi_nev'];
            $_SESSION['uto_nev'] = $felhasznalo['uto_nev'];
            header("Location: index.php?oldal=fooldal");
            exit;
        } else {
            $uzenet = "Hibás felhasználónév vagy jelszó!";
        }
    }
}
?>
<div class="belepes-tartalom">
    <h2>Bejelentkezés</h2>
    <?php if($uzenet): ?>
        <p style="color: red;"><strong><?= $uzenet ?></strong></p>
    <?php endif; ?>
    <form action="index.php?oldal=bejelentkezes" method="post">
        <label>Felhasználónév:</label><br>
        <input type="text" name="felhasznalo" required><br><br>
        <label>Jelszó:</label><br>
        <input type="password" name="jelszo" required><br><br>
        <input type="submit" name="belepes" value="Belépés">
    </form>
    <br>
    <p>Nincs még fiókod? <a href="index.php?oldal=regisztracio">Regisztrálj itt!</a></p>
</div>