<?php
$rendszer_uzenet = "";
$uzenet_tipus = ""; 

if (isset($_POST['kuld'])) {
    $nev = trim($_POST['nev']);
    $email = trim($_POST['email']);
    $szoveg = trim($_POST['szoveg']);

    if (empty($nev) || empty($email) || empty($szoveg)) {
        $rendszer_uzenet = "Szerver hiba: Minden mezőt kötelező kitölteni!";
        $uzenet_tipus = "hiba";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $rendszer_uzenet = "Szerver hiba: Érvénytelen e-mail cím!";
        $uzenet_tipus = "hiba";
    } else {
        $belepes = (isset($_SESSION['login']) && $_SESSION['login'] != false) ? $_SESSION['login'] : 'Vendég';
        
        $sql = "INSERT INTO uzenetek (nev, email, szoveg, idopont, login) VALUES (:nev, :email, :szoveg, NOW(), :login)";
        $stmt = $dbh->prepare($sql);
        
        if ($stmt->execute(['nev' => $nev, 'email' => $email, 'szoveg' => $szoveg, 'login' => $belepes])) {
            $rendszer_uzenet = "Sikeresen elküldted az üzenetet!";
            $uzenet_tipus = "siker";
        } else {
            $rendszer_uzenet = "Adatbázis hiba történt!";
            $uzenet_tipus = "hiba";
        }
    }
}
?>

<div class="form-container">
    <h2>Kapcsolatfelvétel</h2>
    
    <?php if($rendszer_uzenet): ?>
        <div class="status-msg <?= $uzenet_tipus ?>">
            <?= $rendszer_uzenet ?>
        </div>
    <?php endif; ?>

    <form name="kapcsolatUrlap" action="index.php?oldal=kapcsolat" method="post" onsubmit="return urlapEllenorzes()">
        <div class="input-group">
            <label for="nev">Név:</label>
            <input type="text" id="nev" name="nev" placeholder="Írd ide a neved...">
        </div>
        
        <div class="input-group">
            <label for="email">E-mail cím:</label>
            <input type="text" id="email" name="email" placeholder="pelda@email.com">
        </div>
        
        <div class="input-group">
            <label for="szoveg">Üzenet:</label>
            <textarea id="szoveg" name="szoveg" rows="6" placeholder="..."></textarea>
        </div>
        
        <button type="submit" name="kuld" class="btn-submit">Üzenet küldése</button>
    </form>
</div>

<script>
function urlapEllenorzes() {
    let nev = document.forms["kapcsolatUrlap"]["nev"].value;
    let email = document.forms["kapcsolatUrlap"]["email"].value;
    let szoveg = document.forms["kapcsolatUrlap"]["szoveg"].value;

    if (nev.trim() === "" || email.trim() === "" || szoveg.trim() === "") {
        alert("Kliens hiba: Minden mező kitöltése kötelező!");
        return false;
    }

    let emailMinta = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailMinta.test(email)) {
        alert("Kliens hiba: Kérem adjon meg egy érvényes e-mail címet!");
        return false;
    }
    return true;
}
</script>