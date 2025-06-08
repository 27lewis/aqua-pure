<?php

require_once 'conexion.php'; // Incluye tu archivo de conexión PDO
session_start();

// Verificar si es moderador
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'moderador') {
    header('Location: iniciarsesion.php');
    exit();
}

// --- Obtener información del moderador ---
$moderador = null;
try {
    $stmt = $conn->prepare("SELECT nombre, email FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $moderador = $stmt->fetch(); // Ya está configurado para FETCH_ASSOC por defecto en 'conexion.php'
} catch (PDOException $e) {
    error_log("Error al obtener información del moderador: " . $e->getMessage());
    // Puedes manejar esto mostrando un mensaje al usuario o redirigiendo
    die("Error al cargar la información del moderador.");
}

// --- Obtener estadísticas ---
$total_usuarios = 0;
$total_mensajes_contacto = 0;
$total_hilos_foro = 0;

try {
    $total_usuarios = $conn->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
} catch (PDOException $e) {
    error_log("Error al obtener total de usuarios: " . $e->getMessage());
}

try {
    // ESTA ES LA LÍNEA QUE DABA EL ERROR ANTES, AHORA QUE LA TABLA EXISTE, DEBERÍA FUNCIONAR
    $total_mensajes_contacto = $conn->query("SELECT COUNT(*) FROM contactos")->fetchColumn();
} catch (PDOException $e) {
    error_log("Error al obtener total de mensajes de contacto: " . $e->getMessage());
}

try {
    $total_hilos_foro = $conn->query("SELECT COUNT(*) FROM foro_hilos")->fetchColumn();
} catch (PDOException $e) {
    error_log("Error al obtener total de hilos del foro: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inicio.css">
    <title>Aqua Pure - Panel de Moderador</title>
    <style>
        /* Tus estilos CSS existentes */
        .dashboard {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-card h3 {
            color: #007B7F;
            margin-top: 0;
        }

        .stat-card .number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #00a650;
            margin: 10px 0;
        }

        .panel-sections {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .panel-section {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .panel-section h3 {
            color: #007B7F;
            border-bottom: 2px solid #4de2e2;
            padding-bottom: 10px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-action {
            padding: 8px 15px;
            background-color: #007B7F;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-action:hover {
            background-color: #005f5f;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .badge-moderador {
            background-color: #007B7F;
            color: white;
        }

        .badge-cliente {
            background-color: #00a650;
            color: white;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

    <main>
        <div class="contenido">
            <h2>Panel de Moderador</h2>
            <p>Bienvenido, <?php echo htmlspecialchars($moderador['nombre'] ?? 'Invitado'); ?> (<?php echo htmlspecialchars($moderador['email'] ?? 'N/A'); ?>)</p>

            <div class="dashboard">
                <div class="stat-card">
                    <h3>Usuarios Registrados</h3>
                    <div class="number"><?php echo $total_usuarios; ?></div>
                    <a href="#usuarios" class="btn-action">Gestionar</a>
                </div>

                <div class="stat-card">
                    <h3>Mensajes de Contacto</h3>
                    <div class="number"><?php echo $total_mensajes_contacto; ?></div>
                    <a href="#contacto" class="btn-action">Gestionar</a>
                </div>

                <div class="stat-card">
                    <h3>Hilos del Foro</h3>
                    <div class="number"><?php echo $total_hilos_foro; ?></div>
                    <a href="#foro" class="btn-action">Gestionar</a>
                </div>
            </div>

            <div class="panel-sections">
                <div class="panel-section" id="usuarios">
                    <h3>Gestión de Usuarios</h3>
                    <?php
                    $usuarios = []; // Inicializar para evitar errores si la consulta falla
                    try {
                        $usuarios = $conn->query("SELECT id, nombre, email, tipo_usuario FROM usuarios ORDER BY id DESC LIMIT 5")->fetchAll();
                    } catch (PDOException $e) {
                        error_log("Error al obtener usuarios para la tabla: " . $e->getMessage());
                        echo "<p>Error al cargar la lista de usuarios.</p>";
                    }
                    ?>

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
                                        <a href="editar_usuario.php?id=<?php echo htmlspecialchars($usuario['id']); ?>" class="btn-action">Editar</a>
                                        <a href="eliminar_usuario.php?id=<?php echo htmlspecialchars($usuario['id']); ?>" class="btn-action" onclick="return confirm('¿Estás seguro de eliminar a este usuario?')">Eliminar</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5">No hay usuarios para mostrar.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="action-buttons">
                        <a href="listar_usuarios.php" class="btn-action">Ver todos los usuarios</a>
                        <a href="crear_usuario.php" class="btn-action">Crear nuevo usuario</a>
                    </div>
                </div>

                <div class="panel-section" id="mensajes-contacto">
    <h3>Mensajes de Contacto</h3>
    <?php
    $mensajes = []; // Inicializar variable
    try {
        $stmt = $conn->query("SELECT id, nombre, correo, comentario, fecha FROM contactos ORDER BY fecha DESC LIMIT 5");
        $mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener mensajes de contacto: " . $e->getMessage());
        echo "<p>Error al cargar la lista de mensajes de contacto.</p>";
    }
    ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Comentario</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($mensajes)): ?>
                <?php foreach ($mensajes as $mensaje): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($mensaje['id']); ?></td>
                        <td><?php echo htmlspecialchars($mensaje['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($mensaje['correo']); ?></td>
                        <td><?php echo htmlspecialchars($mensaje['comentario']); ?></td>
                        <td><?php echo htmlspecialchars($mensaje['fecha']); ?></td>
                        <td>
                            <a href="ver_mensaje.php?id=<?php echo $mensaje['id']; ?>" class="btn-action">Ver</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No hay mensajes de contacto para mostrar.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    
</div>


                <div class="panel-section" id="foro">
                    <h3>Gestión del Foro</h3>
                    <?php
                    $hilos = []; // Inicializar para evitar errores si la consulta falla
                    try {
                        $hilos = $conn->query("
                            SELECT f.id, f.titulo, u.nombre as autor, f.fecha_creacion, COUNT(r.id) as respuestas
                            FROM foro_hilos f
                            LEFT JOIN usuarios u ON f.usuario_id = u.id
                            LEFT JOIN foro_respuestas r ON f.id = r.hilo_id
                            GROUP BY f.id
                            ORDER BY f.fecha_creacion DESC
                            LIMIT 5
                        ")->fetchAll();
                    } catch (PDOException $e) {
                        error_log("Error al obtener hilos del foro para la tabla: " . $e->getMessage());
                        echo "<p>Error al cargar la lista de hilos del foro.</p>";
                    }
                    ?>

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Respuestas</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($hilos)): ?>
                                <?php foreach ($hilos as $hilo): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($hilo['id']); ?></td>
                                    <td><?php echo htmlspecialchars($hilo['titulo']); ?></td>
                                    <td><?php echo htmlspecialchars($hilo['autor'] ?? 'Desconocido'); ?></td>
                                    <td><?php echo htmlspecialchars($hilo['respuestas']); ?></td>
                                    <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($hilo['fecha_creacion']))); ?></td>
                                    <td>
                                        <a href="ver_hilo.php?id=<?php echo htmlspecialchars($hilo['id']); ?>" class="btn-action">Ver</a>
                                        <a href="editar_hilo.php?id=<?php echo htmlspecialchars($hilo['id']); ?>" class="btn-action">Editar</a>
                                        <a href="eliminar_hilo.php?id=<?php echo htmlspecialchars($hilo['id']); ?>" class="btn-action" onclick="return confirm('¿Estás seguro de eliminar este hilo y sus respuestas?')">Eliminar</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6">No hay hilos en el foro para mostrar.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="action-buttons">
                        <a href="listar_hilos.php" class="btn-action">Ver todos los hilos</a>
                        <a href="nuevo_hilo.php" class="btn-action">Crear nuevo hilo</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php include 'footer.php'; ?>
</body>
</html>