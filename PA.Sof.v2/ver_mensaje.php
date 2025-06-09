<?php
require_once 'conexion.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'moderador') {
    header('Location: iniciarsesion.php');
    exit();
}

$mensaje_id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM contactos WHERE id = ?");
$stmt->execute([$mensaje_id]);
$mensaje = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mensaje) {
    header('Location: panel_moderador.php#contacto');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $respuesta = trim($_POST['respuesta']);
    
    if (empty($respuesta)) {
        $error = 'La respuesta no puede estar vacía.';
    } else {
        try {
            $stmt = $conn->prepare("UPDATE contactos SET estado = 'respondido' WHERE id = ?");
            $stmt->execute([$mensaje_id]);
            
            $stmt = $conn->prepare("INSERT INTO respuestas_contacto (mensaje_id, moderador_id, respuesta) VALUES (?, ?, ?)");
            $stmt->execute([$mensaje_id, $_SESSION['user_id'], $respuesta]);
            
            $success = 'Respuesta enviada correctamente.';
        } catch (PDOException $e) {
            $error = 'Error al procesar la respuesta: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="inicio.css" />
  <title>Aqua Pure - Mensaje de Contacto</title>
  <style>
    .boton-volver {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007BFF;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s;
      margin-top: 20px;
    }
    .boton-volver:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<?php include 'header.php'; ?>

<main>
  <div class="contenido">
    <h2>Mensaje de Contacto</h2>

    <?php if ($error): ?>
      <div class="error-message" style="color: red;"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="success-message" style="color: green;"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <div class="mensaje-container">
      <div class="mensaje-header">
        <h3><?php echo htmlspecialchars($mensaje['asunto'] ?? 'Sin asunto'); ?></h3>
      </div>
      <div class="mensaje-body">
        <div class="mensaje-meta">
          <span>De: <?php echo htmlspecialchars($mensaje['nombre'] ?? 'Anónimo'); ?> &lt;<?php echo htmlspecialchars($mensaje['correo'] ?? 'Sin correo'); ?>&gt;</span>
          <span>Fecha: <?php echo isset($mensaje['fecha']) ? date('d/m/Y H:i', strtotime($mensaje['fecha'])) : 'Sin fecha'; ?></span>
          <span class="estado-badge estado-<?php echo htmlspecialchars($mensaje['estado'] ?? 'nuevo'); ?>">
            <?php
            switch($mensaje['estado'] ?? 'nuevo') {
              case 'nuevo': echo 'Nuevo'; break;
              case 'respondido': echo 'Respondido'; break;
              case 'resuelto': echo 'Resuelto'; break;
              default: echo 'Desconocido'; break;
            }
            ?>
          </span>
        </div>
        <div class="mensaje-contenido">
          <p><?php echo nl2br(htmlspecialchars($mensaje['comentario'] ?? 'Sin mensaje')); ?></p>
        </div>
      </div>
    </div>

    <a href="panel_moderador.php#contacto" class="boton-volver">← Volver al panel de moderador</a>
    
  </div>
</main>

<?php include 'footer.php'; ?>

</body>
</html>
