<h2>Képgaléria</h2>

<?php if (isset($_SESSION['user'])): ?>
<form action="api.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="upload_image">
    <input type="file" name="image" required>
    <button type="submit">Feltöltés</button>
</form>
<?php else: ?>
<p>A képfeltöltéshez be kell jelentkezni.</p>
<?php endif; ?>

<hr>

<h3>Feltöltött képek</h3>

<div class="image-grid">
<?php
$files = glob("public/uploads/images/*.*");
foreach ($files as $file) {
    echo "<img src='" . htmlspecialchars($file, ENT_QUOTES, 'UTF-8') . "' class='gallery-image'>";
}
?>
</div>
