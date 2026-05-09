<?php
$uzenet = "";
$konyvtar = './uploads/';

if (!file_exists($konyvtar)) {
    mkdir($konyvtar, 0777, true);
}

if (isset($_POST['kuld']) && isset($_SESSION['login'])) {
    foreach($_FILES as $fajl) {
        if ($fajl['error'] == 4) {
            $uzenet = "Nem választott ki fájlt!";
        } elseif ($fajl['error'] == 1 || $fajl['error'] == 2) {
            $uzenet = "Túl nagy fájl!";
        } elseif ($fajl['error'] == 0) {
            $tipus = strtolower(pathinfo($fajl['name'], PATHINFO_EXTENSION));
            $engedelyezett = array('jpg', 'jpeg', 'png', 'gif');
            
            if (in_array($tipus, $engedelyezett)) {
                $cel = $konyvtar . basename($fajl['name']);
                if (move_uploaded_file($fajl['tmp_name'], $cel)) {
                    $uzenet = "Sikeres feltöltés!";
                } else {
                    $uzenet = "Hiba a fájl mozgatásakor!";
                }
            } else {
                $uzenet = "Nem megfelelő fájltípus!";
            }
        }
    }
}
?>

<div class="kepek-tartalom">
    <h2>Képgaléria</h2>
    
    <?php if($uzenet): ?>
        <p><strong><?= $uzenet ?></strong></p>
    <?php endif; ?>

    <?php if(isset($_SESSION['login'])): ?>
        <form action="index.php?oldal=kepek" method="post" enctype="multipart/form-data" style="margin-bottom: 20px;">
            <label for="kep">Új kép feltöltése:</label>
            <input type="file" name="kep" id="kep" required>
            <input type="submit" name="kuld" value="Feltöltés">
        </form>
        <hr>
    <?php endif; ?>

    <div class="galeria" style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 20px;">
        <?php
        $kepek = glob($konyvtar . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
        if (!empty($kepek)) {
            foreach ($kepek as $kep) {
                echo '<img src="' . $kep . '" alt="Kép" style="max-width: 300px; height: auto; border: 1px solid #ccc; padding: 5px; border-radius: 5px;">';
            }
        } else {
            echo "<p>Még nincsenek feltöltött képek.</p>";
        }
        ?>
    </div>
</div>