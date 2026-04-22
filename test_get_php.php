<?php
$meno = $_GET['meno'] ?? 'Hosť';
$vek  = $_GET['vek'] ?? 'nezadaný';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Test GET</title>
</head>
<body>
    <p>Ahoj, <?php echo htmlspecialchars($meno); ?>, tvoj vek je: <?php echo htmlspecialchars($vek); ?></p>
</body>
</html>