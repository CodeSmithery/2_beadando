<?php
if (!isset($_SESSION['user'])) {
    echo "<p>Az üzenetek megtekintéséhez be kell jelentkezni.</p>";
    return;
}

require "includes/db.php";

$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll();
?>

<h2>Beérkezett üzenetek</h2>

<table class="data-table">
    <tr>
        <th>Név</th>
        <th>Email</th>
        <th>Üzenet</th>
        <th>Küldés ideje</th>
        <th>Küldő</th>
    </tr>

    <?php foreach ($messages as $m): ?>
    <tr>
        <td><?= htmlspecialchars($m['name']) ?></td>
        <td><?= htmlspecialchars($m['email']) ?></td>
        <td><?= nl2br(htmlspecialchars($m['message'])) ?></td>
        <td><?= htmlspecialchars($m['created_at']) ?></td>
        <td><?= htmlspecialchars($m['user_name']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
