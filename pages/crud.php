<?php
if (isset($_GET['torol'])) {
    $stmt = $dbh->prepare("DELETE FROM hajo WHERE az = :az");
    $stmt->execute(['az' => $_GET['torol']]);
    header("Location: index.php?oldal=crud");
    exit;
}

if (isset($_POST['mentes'])) {
    $az = $_POST['az'];
    $nev = $_POST['nev'];
    $tipus = $_POST['tipus'];
    $tulaz = !empty($_POST['tulaz']) ? $_POST['tulaz'] : null;
    $uzemel = isset($_POST['uzemel']) ? 1 : 0;

    if ($_POST['muvelet'] == 'uj') {
        $stmt = $dbh->prepare("INSERT INTO hajo (az, nev, tipus, tulaz, uzemel) VALUES (:az, :nev, :tipus, :tulaz, :uzemel)");
        $stmt->execute(['az' => $az, 'nev' => $nev, 'tipus' => $tipus, 'tulaz' => $tulaz, 'uzemel' => $uzemel]);
    } else {
        $stmt = $dbh->prepare("UPDATE hajo SET nev=:nev, tipus=:tipus, tulaz=:tulaz, uzemel=:uzemel WHERE az=:az");
        $stmt->execute(['nev' => $nev, 'tipus' => $tipus, 'tulaz' => $tulaz, 'uzemel' => $uzemel, 'az' => $az]);
    }
    header("Location: index.php?oldal=crud");
    exit;
}

$muvelet = $_GET['muvelet'] ?? 'lista';
$szerkeszt_adat = null;

if ($muvelet == 'szerkeszt' && isset($_GET['id'])) {
    $stmt = $dbh->prepare("SELECT * FROM hajo WHERE az = :az");
    $stmt->execute(['az' => $_GET['id']]);
    $szerkeszt_adat = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="crud-tartalom">
    <?php if ($muvelet == 'lista'): ?>
        <div style="margin-bottom: 20px;">
            <a href="index.php?oldal=crud&muvelet=uj" style="background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold;">Add New</a>
        </div>
        
        <?php
        $stmt = $dbh->query("SELECT * FROM hajo");
        $hajok = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-family: sans-serif;">
            <tr style="border-bottom: 2px solid #ddd;">
                <th style="padding: 12px;">Azonosító</th>
                <th style="padding: 12px;">Név</th>
                <th style="padding: 12px;">Típus</th>
                <th style="padding: 12px;">Tulajdonos ID</th>
                <th style="padding: 12px;">Üzemel</th>
                <th style="padding: 12px; text-align: right;">Actions</th>
            </tr>
            <?php foreach ($hajok as $h): ?>
                <tr style="border-bottom: 1px solid #ddd; background-color: #f9f9f9;">
                    <td style="padding: 12px;"><?= $h['az'] ?></td>
                    <td style="padding: 12px;"><?= htmlspecialchars($h['nev']) ?></td>
                    <td style="padding: 12px;"><?= htmlspecialchars($h['tipus']) ?></td>
                    <td style="padding: 12px;"><?= $h['tulaz'] ?></td>
                    <td style="padding: 12px;"><?= $h['uzemel'] ? 'Igen' : 'Nem' ?></td>
                    <td style="padding: 12px; text-align: right;">
                        <a href="index.php?oldal=crud&muvelet=szerkeszt&id=<?= $h['az'] ?>" style="background: #17a2b8; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; margin-right: 5px;">Edit</a>
                        <a href="index.php?oldal=crud&torol=<?= $h['az'] ?>" onclick="return confirm('Biztosan törlöd?')" style="background: #dc3545; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px;">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

    <?php elseif ($muvelet == 'uj' || $muvelet == 'szerkeszt'): ?>
        <h2><?= $muvelet == 'uj' ? 'Új hajó felvétele' : 'Hajó szerkesztése' ?></h2>
        <form action="index.php?oldal=crud" method="post" style="max-width: 400px; background: #f4f4f4; padding: 20px; border-radius: 5px;">
            <input type="hidden" name="muvelet" value="<?= $muvelet ?>">
            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Azonosító (szám):</label><br>
                <input type="number" name="az" value="<?= $szerkeszt_adat ? $szerkeszt_adat['az'] : '' ?>" <?= $szerkeszt_adat ? 'readonly' : 'required' ?> style="width: 100%; padding: 8px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Név:</label><br>
                <input type="text" name="nev" value="<?= $szerkeszt_adat ? htmlspecialchars($szerkeszt_adat['nev']) : '' ?>" required style="width: 100%; padding: 8px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Típus:</label><br>
                <input type="text" name="tipus" value="<?= $szerkeszt_adat ? htmlspecialchars($szerkeszt_adat['tipus']) : '' ?>" style="width: 100%; padding: 8px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold;">Tulajdonos azonosítója (szám):</label><br>
                <input type="number" name="tulaz" value="<?= $szerkeszt_adat ? $szerkeszt_adat['tulaz'] : '' ?>" style="width: 100%; padding: 8px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold;">
                    <input type="checkbox" name="uzemel" value="1" <?= ($szerkeszt_adat && $szerkeszt_adat['uzemel']) ? 'checked' : '' ?>> Jelenleg üzemel
                </label>
            </div>
            
            <input type="submit" name="mentes" value="Mentés" style="background: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
            <a href="index.php?oldal=crud" style="margin-left: 15px; text-decoration: none; color: #333;">Mégse</a>
        </form>
    <?php endif; ?>
</div>