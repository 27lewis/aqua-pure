<?php
require_once 'conexion.php';
session_start();

// Verificar permisos de moderador
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'moderador') {
    header('Location: iniciarsesion.php');
    exit();
}

// Obtener todos los usuarios
$usuarios = [];
try {
    $usuarios = $conn->query("SELECT id, nombre, email, tipo_usuario FROM usuarios ORDER BY id DESC")->fetchAll();
} catch (PDOException $e) {
    error_log("Error al obtener usuarios: " . $e->getMessage());
    $error = "Error al cargar la lista de usuarios";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios - Aqua Pure</title>
    <link rel="stylesheet" href="inicio.css">
    <style>
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-buttons {
            margin-top: 20px;
        }
        .btn {
            padding: 8px 15px;
            background-color: #007B7F;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
            color: white;
        }
        .badge-moderador {
            background-color: #007B7F;
        }
        .badge-cliente {
            background-color: #00a650;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container">
    <h2>Lista Completa de Usuarios</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                    <td>
                        <span class="badge <?php echo $usuario['tipo_usuario'] == 'moderador' ? 'badge-moderador' : 'badge-cliente'; ?>">
                            <?php echo htmlspecialchars($usuario['tipo_usuario'] == 'moderador' ? 'Moderador' : 'Cliente'); ?>
                        </span>
                    </td>
                    <td>
                        <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn">Editar</a>
                        <a href="eliminar_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">No hay usuarios registrados</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div class="action-buttons">
        <a href="panel_moderador.php" class="btn">Volver al Panel</a>
        <a href="crear_usuario.php" class="btn">Crear Nuevo Usuario</a>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>