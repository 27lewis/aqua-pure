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

// Procesar formulario
if ($_POST) {
    $contrasena_actual = $_POST['contrasena_actual'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];
    
    // Validaciones
    if (empty($contrasena_actual)) {
        $error = 'Ingresa tu contraseña actual';
    } elseif (empty($nueva_contrasena)) {
        $error = 'Ingresa la nueva contraseña';
    } elseif (strlen($nueva_contrasena) < 6) {
        $error = 'La nueva contraseña debe tener al menos 6 caracteres';
    } elseif ($nueva_contrasena !== $confirmar_contrasena) {
        $error = 'Las contraseñas no coinciden';
    } else {
        // Verificar contraseña actual
        $stmt = $conn->prepare("SELECT password FROM usuarios WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user || !password_verify($contrasena_actual, $user['password'])) {
            $error = 'La contraseña actual es incorrecta';
        } else {
            // Actualizar contraseña
            try {
                $nueva_contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
                $stmt->execute([$nueva_contrasena_hash, $_SESSION['user_id']]);
                
                $message = 'Contraseña actualizada correctamente';
            } catch (PDOException $e) {
                $error = 'Error al actualizar la contraseña: ' . $e->getMessage();
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
    <title>Aqua Pure - Cambiar Contraseña</title>
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
                <h2>Cambiar Contraseña</h2>
                
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
                        <label for="contrasena_actual">Contraseña Actual:</label>
                        <input type="password" id="contrasena_actual" name="contrasena_actual" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nueva_contrasena">Nueva Contraseña:</label>
                        <input type="password" id="nueva_contrasena" name="nueva_contrasena" 
                               minlength="6" required>
                        <small class="form-help">Mínimo 6 caracteres</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirmar_contrasena">Confirmar Nueva Contraseña:</label>
                        <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" 
                               minlength="6" required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-action btn-primary">Cambiar Contraseña</button>
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

    <script>
        // Validación en tiempo real de confirmación de contraseña
        document.getElementById('confirmar_contrasena').addEventListener('input', function() {
            const nueva = document.getElementById('nueva_contrasena').value;
            const confirmar = this.value;
            
            if (nueva !== confirmar && confirmar.length > 0) {
                this.setCustomValidity('Las contraseñas no coinciden');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>
</html>