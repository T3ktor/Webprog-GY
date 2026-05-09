<?php
if (!isset($_SESSION['login'])) {
    die("Nincs jogosultsága az oldal megtekintéséhez!");
}

$sql = "SELECT nev, email, szoveg, idopont, login FROM uzenetek ORDER BY idopont DESC";
$stmt = $dbh->query($sql);
$uzenetlista = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="uzenetek-tartalom">
    <h2>Beérkezett üzenetek</h2>
    
    <?php if (count($uzenetlista) > 0): ?>
        <table border="1" style="width: 100%; border-collapse: collapse; text-align: left; margin-top: 20px;">
            <tr style="background-color: #004d7a; color: white;">
                <th style="padding: 10px;">Időpont</th>
                <th style="padding: 10px;">Név</th>
                <th style="padding: 10px;">Fiók</th>
                <th style="padding: 10px;">E-mail</th>
                <th style="padding: 10px;">Üzenet</th>
            </tr>
            <?php foreach ($uzenetlista as $uzenet): ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($uzenet['idopont']) ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($uzenet['nev']) ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($uzenet['login']) ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($uzenet['email']) ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?= nl2br(htmlspecialchars($uzenet['szoveg'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Még nem érkezett egyetlen üzenet sem.</p>
    <?php endif; ?>
</div>