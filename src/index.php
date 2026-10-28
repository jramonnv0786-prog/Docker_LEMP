<?php
// Credenciales recibidas como variables de entorno desde docker-compose.yml
$host = getenv('DB_HOST') ?: 'mysql';
$db   = getenv('DB_NAME') ?: '';
$user = getenv('DB_USER') ?: '';
$pass = getenv('DB_PASSWORD') ?: '';

$dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $version = $pdo->query('SELECT VERSION()')->fetchColumn();
    $ok      = true;
    $mensaje = "Conexión exitosa a la base de datos '{$db}' en el host '{$host}' (MySQL {$version}).";
} catch (PDOException $e) {
    $ok      = false;
    $mensaje = 'Error de conexión: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>LEMP con Docker Compose</title>
    <style>
        .estado { max-width: 934px; margin: 20px auto; padding: 16px 20px;
                  font: 16px/1.4 sans-serif; border-radius: 6px; }
        .estado.ok    { background: #e6f6ec; border-left: 6px solid #1e8e3e; color: #14532d; }
        .estado.error { background: #fdecea; border-left: 6px solid #c62828; color: #7f1d1d; }
    </style>
</head>
<body>
    <div class="estado <?= $ok ? 'ok' : 'error' ?>">
        <?= htmlspecialchars($mensaje) ?>
    </div>
    <?php phpinfo(); ?>
</body>
</html>