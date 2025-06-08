<?php
require_once 'conexion.php';
session_start();

// Redirigir si no está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: iniciarsesion.php');
    exit();
}

$message = '';
$error = '';

// Obtener información actual del usuario
$stmt = $conn->prepare("SELECT nombre, email FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header('Location: iniciarsesion.php');
    exit();
}

// Procesar formulario
if ($_POST) {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    
    // Validaciones
    if (empty($nombre)) {
        $error = 'El nombre es obligatorio';
    } elseif (empty($email)) {
        $error = 'El email es obligatorio';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El email no es válido';
    } else {
        // Verificar si el email ya existe (excepto el actual)
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
        $stmt->execute([$email, $_SESSION['user_id']]);
        
        if ($stmt->fetch()) {
            $error = 'Este email ya está registrado';
        } else {
            // Actualizar información
            try {
                $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?");
                $stmt->execute([$nombre, $email, $_SESSION['user_id']]);
                
                $message = 'Perfil actualizado correctamente';
                $user['nombre'] = $nombre;
                $user['email'] = $email;
            } catch (PDOException $e) {
                $error = 'Error al actualizar el perfil';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="miperfil.css">
    <title>Aqua Pure - Editar Perfil</title>
</head>
<body>
    <header>
        <nav>
            <img src="logo.png" alt="Aqua Pure logo representando la conservación del agua" class="logo" loading="lazy">
            <ul class="nav-links">
                <li><a href="inicio.php">Inicio</a></li>
                <li><a href="guia.php">Guías</a></li>
                <li>
                    <a href="#" aria-haspopup="true" aria-expanded="false">Quiénes Somos</a>
                    <ul class="sub-menu" role="menu">
                        <li><a href="vision.php" role="menuitem">Nuestra Visión</a></li>
                        <li><a href="organizacion.php" role="menuitem">Organización</a></li>
                        <li><a href="comotrabajamos.php" role="menuitem">Cómo Trabajamos</a></li>
                        <li><a href="dondetrabajamos.php" role="menuitem">Dónde Trabajamos</a></li>
                    </ul>
                </li>
                <li><a href="foro.php">Foro</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
            <div class="auth-buttons">
                <a href="perfil.php" class="btn">Mi Perfil</a>
                <a href="logout.php" class="btn">Cerrar Sesión</a>
            </div>
        </nav>
    </header>
    
    <main>
        <div class="contenido">
            <div class="seccion">
                <h2>Editar Perfil</h2>
                
                <?php if ($message): ?>
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="profile-form">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" 
                               value="<?php echo htmlspecialchars($user['nombre']); ?>" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Correo electrónico:</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo htmlspecialchars($user['email']); ?>" 
                               required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-action btn-primary">Guardar Cambios</button>
                        <a href="perfil.php" class="btn-action btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p>© 2025 Aqua Pure - Todos los derechos reservados</p>
        <p>Comprometidos con la conservación del agua y el medio ambiente</p>
        <div class="social-links">
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">Instagram</a>
            <a href="#">YouTube</a>
        </div>
    </footer>
</body>
</html>