<?php
require "includes/db.php";

$action = $_GET['action'] ?? 'list';

// --- LISTÁZÁS ---
if ($action == 'list') {

    $stmt = $pdo->query("
        SELECT varos.*, megye.nev AS megye_nev
        FROM varos
        JOIN megye ON varos.megyeid = megye.id
        ORDER BY varos.nev
    ");
    $rows = $stmt->fetchAll();

    echo "<h2>Városok</h2>";
    echo '<a href="index.php?page=crud&action=new">Új város felvétele</a><br><br>';

    echo "<table border='1' cellpadding='8'>";
    echo "<tr>
            <th>ID</th>
            <th>Név</th>
            <th>Megye</th>
            <th>Megyeszékhely</th>
            <th>Megyei jogú</th>
            <th>Műveletek</th>
          </tr>";

    foreach ($rows as $r) {
        echo "<tr>
                <td>{$r['id']}</td>
                <td>{$r['nev']}</td>
                <td>{$r['megye_nev']}</td>
                <td>" . ($r['megyeszekhely'] ? "Igen" : "Nem") . "</td>
                <td>" . ($r['megyeijogu'] ? "Igen" : "Nem") . "</td>
                <td>
                    <a href='index.php?page=crud&action=edit&id={$r['id']}'>Szerkesztés</a> |
                    <a href='index.php?page=crud&action=delete&id={$r['id']}'
                       onclick='return confirm(\"Biztos törlöd?\")'>Törlés</a>
                </td>
              </tr>";
    }

    echo "</table>";
}
// --- ÚJ VÁROS FELVÉTELE ---
if ($action == 'new') {

    // Megyék lekérése a legördülő listához
    $megyek = $pdo->query("SELECT * FROM megye ORDER BY nev")->fetchAll();

    echo "<h2>Új város felvétele</h2>";

    echo '<form method="POST" action="api.php" enctype="application/x-www-form-urlencoded">
            <input type="hidden" name="action" value="varos_create">

            Név:<br>
            <input type="text" name="nev"><br><br>

            Megye:<br>
            <select name="megyeid">';
                foreach ($megyek as $m) {
                    echo "<option value='{$m['id']}'>{$m['nev']}</option>";
                }
    echo    '</select><br><br>

            Megyeszékhely:<br>
            <select name="megyeszekhely">
                <option value="0">Nem</option>
                <option value="1">Igen</option>
            </select><br><br>

            Megyei jogú:<br>
            <select name="megyeijogu">
                <option value="0">Nem</option>
                <option value="1">Igen</option>
            </select><br><br>

            <button type="submit">Mentés</button>
          </form>';
}
// --- VÁROS SZERKESZTÉSE ---
if ($action == 'edit') {

    $id = $_GET['id'] ?? 0;

    // Város adatainak lekérése
    $stmt = $pdo->prepare("SELECT * FROM varos WHERE id = ?");
    $stmt->execute([$id]);
    $varos = $stmt->fetch();

    if (!$varos) {
        echo "<p>Nincs ilyen város.</p>";
        return;
    }

    // Megyék lekérése
    $megyek = $pdo->query("SELECT * FROM megye ORDER BY nev")->fetchAll();

    echo "<h2>Város szerkesztése</h2>";

    echo '<form method="POST" action="api.php">
            <input type="hidden" name="action" value="varos_update">
            <input type="hidden" name="id" value="'.$varos['id'].'">

            Név:<br>
            <input type="text" name="nev" value="'.$varos['nev'].'"><br><br>

            Megye:<br>
            <select name="megyeid">';
                foreach ($megyek as $m) {
                    $sel = ($m['id'] == $varos['megyeid']) ? "selected" : "";
                    echo "<option value='{$m['id']}' $sel>{$m['nev']}</option>";
                }
    echo    '</select><br><br>

            Megyeszékhely:<br>
            <select name="megyeszekhely">
                <option value="0" '.($varos['megyeszekhely']==0?"selected":"").'>Nem</option>
                <option value="1" '.($varos['megyeszekhely']==1?"selected":"").'>Igen</option>
            </select><br><br>

            Megyei jogú:<br>
            <select name="megyeijogu">
                <option value="0" '.($varos['megyeijogu']==0?"selected":"").'>Nem</option>
                <option value="1" '.($varos['megyeijogu']==1?"selected":"").'>Igen</option>
            </select><br><br>

            <button type="submit">Mentés</button>
          </form>';
}
// --- VÁROS TÖRLÉSE ---
if ($action == 'delete') {

    $id = $_GET['id'] ?? 0;

    $stmt = $pdo->prepare("DELETE FROM varos WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php?page=crud");
    exit;
}
