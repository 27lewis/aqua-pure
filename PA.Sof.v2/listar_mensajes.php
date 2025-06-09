<?php
require_once 'conexion.php';
session_start();

// Verificar permisos de moderador
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'moderador') {
    header('Location: iniciarsesion.php');
    exit();
}

// Obtener todos los mensajes de contacto
$mensajes = [];
try {
$mensajes = $conn->query("SELECT id, nombre, correo AS email, comentario AS mensaje, estado AS leido, fecha FROM contactos ORDER BY fecha DESC")->fetchAll();
} catch (PDOException $e) {
    error_log("Error al obtener mensajes: " . $e->getMessage());
    $error = "Error al cargar la lista de mensajes";
}

// Marcar mensajes como leídos si es necesario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['marcar_leido'])) {
    try {
        $stmt = $conn->prepare("UPDATE contactos SET leido = 1 WHERE id = ?");
        $stmt->execute([$_POST['marcar_leido']]);
        header("Location: listar_mensajes.php");
        exit();
    } catch (PDOException $e) {
        error_log("Error al marcar mensaje como leído: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes de Contacto - Aqua Pure</title>
    <link rel="stylesheet" href="inicio.css">
    <style>
       body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #22c1c3, #0052d4);
    color: #fff;
}

.container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.2);
    color: #000;
}

h2 {
    color: #fff;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: rgba(255,255,255,0.95);
    border-radius: 10px;
    overflow: hidden;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ccc;
    color: #000;
}

th {
    background-color: #f9f9f9;
}

td:nth-child(4) {
    max-width: 250px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.action-buttons {
    margin-top: 20px;
    text-align: center;
}

.btn {
    padding: 7px 12px;
    background-color: #007B7F;
    color: white;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    margin: 2px 4px;
    cursor: pointer;
}

.btn:hover {
    background-color: #005f5f;
}

.btn-secondary {
    background-color: #6c757d;
}

.btn-secondary:hover {
    background-color: #545b62;
}

.btn-success {
    background-color: #28a745;
}

.btn-success:hover {
    background-color: #1e7e34;
}

.badge {
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: bold;
    color: white;
    display: inline-block;
}

.badge-success {
    background-color: #28a745;
}

.badge-warning {
    background-color: #ffc107;
    color: #000;
}

.message-details {
    display: none;
    background-color: #e9ecef;
    border-left: 5px solid #007B7F;
    padding: 10px;
    color: #000;
}

.no-messages {
    padding: 20px;
    text-align: center;
    background-color: #f8f9fa;
    border-radius: 5px;
}
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <h2>Todos los Mensajes de Contacto</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if (empty($mensajes)): ?>
        <div class="no-messages">
            <p>No hay mensajes de contacto para mostrar</p>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Asunto</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mensajes as $mensaje): ?>
                <tr>
                    <td><?php echo htmlspecialchars($mensaje['id']); ?></td>
                    <td><?php echo htmlspecialchars($mensaje['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($mensaje['email']); ?></td>
                    <td><?php echo htmlspecialchars($mensaje['mensaje']); ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($mensaje['fecha'])); ?></td>
                    <td>
                        <span class="badge <?php echo (isset($mensaje['leido'])) && $mensaje['leido'] ? 'badge-success' : 'badge-warning'; ?>">
                            <?php echo (isset($mensaje['leido'])) && $mensaje['leido'] ? 'Leído' : 'No leído'; ?>
                        </span>
                    </td>
                    <td>
                        <button onclick="toggleMessage(<?php echo $mensaje['id']; ?>)" class="btn">Ver</button>
                        <a href="responder_mensaje.php?id=<?php echo $mensaje['id']; ?>" class="btn btn-success">Responder</a>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="marcar_leido" value="<?php echo $mensaje['id']; ?>">
                            <button type="submit" class="btn">Marcar como leído</button>
                        </form>
                    </td>
                </tr>
                <tr id="details-<?php echo $mensaje['id']; ?>" class="message-details">
                    <td colspan="7">
                        <h4>Mensaje completo:</h4>
                        <p><?php echo nl2br(htmlspecialchars($mensaje['mensaje'])); ?></p>
                        <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($mensaje['fecha'])); ?></p>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
    <div class="action-buttons">
        <a href="panel_moderador.php" class="btn btn-secondary">Volver al Panel</a>
    </div>
</div>

<script>
    function toggleMessage(id) {
        const details = document.getElementById('details-' + id);
        if (details.style.display === 'table-row') {
            details.style.display = 'none';
        } else {
            // Cerrar todos los demás detalles primero
            document.querySelectorAll('.message-details').forEach(el => {
                el.style.display = 'none';
            });
            details.style.display = 'table-row';
        }
    }
</script>

<?php include 'footer.php'; ?>
</body>
</html>