<?php
require_once 'conexion.php';
session_start();

// Verificar conexión (PDO no tiene connect_error, usamos try-catch en conexion.php)
try {
    // Procesar nuevo hilo
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["usuario_id"])) {
        $titulo = trim($_POST["titulo"] ?? '');
        $contenido = trim($_POST["contenido"] ?? '');
        $usuario_id = (int)$_SESSION["usuario_id"];

        if (!empty($titulo) && !empty($contenido)) {
            $stmt = $conn->prepare("INSERT INTO foro_hilos (titulo, contenido, usuario_id) VALUES (:titulo, :contenido, :usuario_id)");
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':contenido', $contenido);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                header("Location: foro.php");
                exit();
            } else {
                error_log("Error al insertar hilo: " . implode(" ", $stmt->errorInfo()));
            }
        }
    }
} catch (PDOException $e) {
    error_log("Error de base de datos: " . $e->getMessage());
    die("Error en el sistema. Por favor, inténtalo más tarde.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aqua Pure - Foro</title>
    <link rel="stylesheet" href="foro.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="contenido">
        <div class="intro">
            <h1>Foro de la Comunidad</h1>
            <p>Comparte ideas, dudas y sugerencias con otros usuarios.</p>
        </div>

        <div class="foro-container">
            <div class="foro-mensajes">
                <?php
                try {
                    $query = "SELECT fh.id, fh.titulo, fh.contenido, u.nombre AS usuario, fh.fecha_creacion
                              FROM foro_hilos fh
                              JOIN usuarios u ON fh.usuario_id = u.id
                              ORDER BY fh.fecha_creacion DESC";
                    
                    $stmt = $conn->query($query);
                    
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<div class="mensaje">';
                            echo '<h3>'.htmlspecialchars($row["titulo"]).'</h3>';
                            echo '<p><strong>'.htmlspecialchars($row["usuario"]).'</strong></p>';
                            echo '<p>'.nl2br(htmlspecialchars($row["contenido"])).'</p>';
                            echo '<div class="fecha">'.htmlspecialchars($row["fecha_creacion"]).'</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p class="no-hilos">No hay hilos en el foro aún. ¡Sé el primero!</p>';
                    }
                } catch (PDOException $e) {
                    echo '<p class="error-mensaje">Error al cargar los hilos.</p>';
                    error_log("Error en consulta: " . $e->getMessage());
                }
                ?>
            </div>

            <?php if (isset($_SESSION["usuario_id"])): ?>
                <form class="foro-form" method="POST">
                    <input type="text" name="titulo" placeholder="Título" required>
                    <textarea name="contenido" rows="4" placeholder="Contenido" required></textarea>
                    <button type="submit">Publicar</button>
                </form>
            <?php else: ?>
                <p>Debes <a href="iniciarsesion.php">iniciar sesión</a> para participar.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
<?php 
// PDO no necesita cerrarse explícitamente, pero si quieres:
$conn = null;
?>