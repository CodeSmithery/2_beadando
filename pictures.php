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

<div style="display:flex; flex-wrap:wrap; gap:10px;">
<?php
$files = glob("public/uploads/images/*.*");
foreach ($files as $file) {
    echo "<img src='$file' style='width:200px; border:1px solid #ccc;'>";
}
?>
</div>