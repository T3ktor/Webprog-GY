<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balatoni Hajók Portál</title>
    <link rel="stylesheet" href="stilus.css">
</head>
<body>
    <header>
        <h1>Balatoni Hajók</h1>
    </header>

    <nav>
        <ul>
            <?php 
            foreach ($oldalak as $url => $oldal) { 
                $belepve = isset($_SESSION['login']) && $_SESSION['login'] !== false;
                $jog = $belepve ? $oldal['menun'][1] : $oldal['menun'][0];
                
                if($jog) { ?>
                    <li>
                        <a href="index.php?oldal=<?= $url ?>" <?= ($oldal == $keresett) ? 'style="border-bottom: 3px solid #ffce00;"' : '' ?>>
                            <?= $oldal['szoveg'] ?>
                        </a>
                    </li>
                <?php } 
            } ?>
        </ul>
    </nav>

    <main>
        <?php 
            $fajl = "./pages/{$keresett['fajl']}.php";
            if(file_exists($fajl)) {
                include($fajl);
            } else {
                include("./pages/404.php");
            }
        ?>
    </main>

    <footer>
        <p>&copy; <?= date("Y") ?> - Balatoni Hajózási Projekt</p>
    </footer>
</body>
</html>