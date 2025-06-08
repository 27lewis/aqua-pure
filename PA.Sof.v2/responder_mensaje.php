<?php
require_once 'conexion.php';
session_start();

// Verificar permisos de moderador
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'moderador') {
    header('Location: iniciarsesion.php');
    exit();
}

// Verificar que se proporcionó un ID
if (!isset($_GET['id'])) {
    header('Location: listar_mensajes.php');
    exit();
}

$id = $_GET['id'];
$error = '';
$success = '';
$mensaje = null;

// Obtener datos del mensaje
try {
    $stmt = $conn->prepare("SELECT id, nombre, email, asunto, mensaje, fecha FROM contactos WHERE id = ?");
    $stmt->execute([$id]);
    $mensaje = $stmt->fetch();
    
    if (!$mensaje) {
        header('Location: listar_mensajes.php');
        exit();
    }
} catch (PDOException $e) {
    error_log("Error al obtener mensaje: " . $e->getMessage());
    $error = 'Error al cargar el mensaje';
}

// Procesar el formulario de respuesta
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $respuesta = trim($_POST['respuesta']);
    $asunto = "Re: " . $mensaje['asunto'];
    
    if (empty($respuesta)) {
        $error = 'La respuesta no puede estar vacía';
    } else {
        try {
            // Aquí deberías implementar el envío real del email
            // Esto es solo un ejemplo simulado
            $enviado = true; // Simular envío exitoso
            
            if ($enviado) {
                // Marcar como respondido en la base de datos
                $stmt = $conn->prepare("UPDATE contactos SET respondido = 1, fecha_respuesta = NOW() WHERE id = ?");
                $stmt->execute([$id]);
                
                $success = 'Respuesta enviada exitosamente';
            } else {
                $error = 'Error al enviar el correo';
            }
        } catch (PDOException $e) {
            error_log("Error al responder mensaje: " . $e->getMessage());
            $error = 'Error al procesar la respuesta';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responder Mensaje - Aqua Pure</title>
    <link rel="stylesheet" href="inicio.css">
    <style>
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .message-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #007B7F;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-height: 150px;
        }
        .btn {
            padding: 8px 15px;
            background-color: #007B7F;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .alert-error {
            background-color: #ffdddd;
            color: #d8000c;
        }
        .alert-success {
            background-color: #ddffdd;
            color: #4F8A10;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <h2>Responder Mensaje</h2>
    
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if ($mensaje): ?>
    <div class="message-info">
        <p><strong>De:</strong> <?php echo htmlspecialchars($mensaje['nombre']); ?> (<?php echo htmlspecialchars($mensaje['email']); ?>)</p>
        <p><strong>Asunto:</strong> <?php echo htmlspecialchars($mensaje['asunto']); ?></p>
        <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($mensaje['fecha'])); ?></p>
        <p><strong>Mensaje:</strong></p>
        <p><?php echo nl2br(htmlspecialchars($mensaje['mensaje'])); ?></p>
    </div>
    
    <form method="POST" action="responder_mensaje.php?id=<?php echo $id; ?>">
        <div class="form-group">
            <label for="respuesta">Respuesta:</label>
            <textarea id="respuesta" name="respuesta" required></textarea>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">Enviar Respuesta</button>
            <a href="listar_mensajes.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>