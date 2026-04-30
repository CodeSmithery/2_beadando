<h2>Üzenet elküldve</h2>

<?php
$stmt = $pdo->query("SELECT * FROM messages ORDER BY id DESC LIMIT 1");
$msg = $stmt->fetch();
?>

<p><strong>Név:</strong> <?= htmlspecialchars($msg['name']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($msg['email']) ?></p>
<p><strong>Üzenet:</strong> <?= nl2br(htmlspecialchars($msg['message'])) ?></p>
<p><strong>Küldés ideje:</strong> <?= $msg['created_at'] ?></p>
<p><strong>Küldő:</strong> <?= $msg['user_name'] ?></p>