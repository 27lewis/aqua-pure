<?php
require_once 'conexion.php';
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $tipo_usuario = $_POST['tipo_usuario'];

    // Validaciones
    if (empty($nombre) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Todos los campos son obligatorios.';
    } elseif ($password !== $confirm_password) {
        $error = 'Las contraseñas no coinciden.';
    } elseif (strlen($password) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres.';
    } else {
        // Verificar si el email ya existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $error = 'Este correo electrónico ya está registrado.';
        } else {
            // Hash de la contraseña
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insertar nuevo usuario
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, tipo_usuario) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$nombre, $email, $hashed_password, $tipo_usuario])) {
                $success = 'Registro exitoso. Ahora puedes iniciar sesión.';
                // Limpiar campos después de registro exitoso
                $nombre = $email = '';
            } else {
                $error = 'Error al registrar el usuario. Por favor, inténtalo de nuevo.';
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
  <link rel="stylesheet" href="registrarse.css">
  <title>Aqua Pure - Registro</title>
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
        <a href="iniciarsesion.php" class="btn">Iniciar Sesión</a>
        <a href="registrarse.php" class="btn">Registrarse</a>
      </div>
    </nav>
  </header>
  
  <main>
    <div class="contenido">
      <div class="seccion">
        <h2>Registro de Usuario</h2>
        
        <?php if ($error): ?>
          <div class="error-message" style="color: red; margin-bottom: 15px;"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
          <div class="success-message" style="color: green; margin-bottom: 15px;"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form action="registrarse.php" method="post" class="form-registro">
          <div class="form-group">
            <label for="nombre">Nombre completo:</label>
            <input type="text" id="nombre" name="nombre" required value="<?php echo isset($nombre) ? htmlspecialchars($nombre) : ''; ?>">
          </div>
          
          <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
          </div>
          
          <div class="form-group">
            <label for="password">Contraseña (mínimo 6 caracteres):</label>
            <input type="password" id="password" name="password" required minlength="6">
          </div>
          
          <div class="form-group">
            <label for="confirm_password">Confirmar contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
          </div>
          
          <div class="form-group">
            <label for="tipo_usuario">Tipo de usuario:</label>
            <select id="tipo_usuario" name="tipo_usuario" required>
              <option value="usuario">Usuario</option>
              <option value="moderador">Moderador</option>
            </select>
          </div>
          
          <button type="submit" class="btn-registro">Registrarse</button>
        </form>
        
        <p style="margin-top: 20px;">¿Ya tienes una cuenta? <a href="iniciarsesion.php">Inicia sesión aquí</a></p>
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