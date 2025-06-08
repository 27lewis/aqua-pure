<?php
require_once 'conexion.php';
session_start();

// Verificar si es moderador
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'moderador') {
    header('Location: iniciarsesion.php');
    exit();
}

// Obtener ID del usuario a editar
$usuario_id = $_GET['id'] ?? 0;

// Obtener información del usuario
$stmt = $conn->prepare("SELECT id, nombre, email, tipo_usuario FROM usuarios WHERE id = ?");
$stmt->execute([$usuario_id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header('Location: panel_moderador.php');
    exit();
}

// Procesar el formulario
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $tipo_usuario = $_POST['tipo_usuario'];
    $cambiar_password = isset($_POST['cambiar_password']);
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    // Validaciones
    if (empty($nombre) || empty($email)) {
        $error = 'Nombre y email son obligatorios.';
    } elseif ($cambiar_password && ($password !== $confirm_password || strlen($password) < 6)) {
        $error = 'Las contraseñas no coinciden o son demasiado cortas (mínimo 6 caracteres).';
    } else {
        try {
            $conn->beginTransaction();
            
            // Verificar si el email ya existe en otro usuario
            $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
            $stmt->execute([$email, $usuario_id]);
            
            if ($stmt->rowCount() > 0) {
                $error = 'Este correo electrónico ya está en uso por otro usuario.';
            } else {
                // Actualizar datos básicos
                $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, tipo_usuario = ? WHERE id = ?");
                $stmt->execute([$nombre, $email, $tipo_usuario, $usuario_id]);
                
                // Actualizar contraseña si se solicitó
                if ($cambiar_password && !empty($password)) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
                    $stmt->execute([$hashed_password, $usuario_id]);
                }
                
                $conn->commit();
                $success = 'Usuario actualizado correctamente.';
                // Refrescar datos del usuario
                $stmt = $conn->prepare("SELECT id, nombre, email, tipo_usuario FROM usuarios WHERE id = ?");
                $stmt->execute([$usuario_id]);
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            $conn->rollBack();
            $error = 'Error al actualizar el usuario: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="inicio.css">
  <title>Aqua Pure - Editar Usuario</title>
  <style>
    .form-container {
      max-width: 600px;
      margin: 0 auto;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #007B7F;
    }
    
    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    
    .checkbox-group {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
    }
    
    .checkbox-group input {
      width: auto;
      margin-right: 10px;
    }
    
    .password-fields {
      display: none;
      margin-top: 15px;
      padding: 15px;
      background-color: #f5f5f5;
      border-radius: 5px;
    }
    
    .btn-submit {
      background-color: #007B7F;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }
    
    .btn-submit:hover {
      background-color: #005f5f;
    }
    
    .btn-back {
      display: inline-block;
      margin-top: 15px;
      color: #007B7F;
      text-decoration: none;
    }
  </style>
  <script>
    function togglePasswordFields() {
      const passwordFields = document.getElementById('password-fields');
      const cambiarPassword = document.getElementById('cambiar_password');
      
      if (cambiarPassword.checked) {
        passwordFields.style.display = 'block';
      } else {
        passwordFields.style.display = 'none';
      }
    }
  </script>
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
        <a href="panel_moderador.php" class="btn">Panel Moderador</a>
        <a href="logout.php" class="btn">Cerrar Sesión</a>
      </div>
    </nav>
  </header>
  
  <main>
    <div class="contenido">
      <h2>Editar Usuario</h2>
      
      <?php if ($error): ?>
        <div class="error-message" style="color: red; margin-bottom: 15px;"><?php echo $error; ?></div>
      <?php endif; ?>
      
      <?php if ($success): ?>
        <div class="success-message" style="color: green; margin-bottom: 15px;"><?php echo $success; ?></div>
      <?php endif; ?>
      
      <div class="form-container">
        <form method="post">
          <div class="form-group">
            <label for="nombre">Nombre completo:</label>
            <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($usuario['nombre']); ?>">
          </div>
          
          <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($usuario['email']); ?>">
          </div>
          
          <div class="form-group">
            <label for="tipo_usuario">Tipo de usuario:</label>
            <select id="tipo_usuario" name="tipo_usuario" required>
              <option value="cliente" <?php echo $usuario['tipo_usuario'] == 'cliente' ? 'selected' : ''; ?>>Cliente</option>
              <option value="moderador" <?php echo $usuario['tipo_usuario'] == 'moderador' ? 'selected' : ''; ?>>Moderador</option>
            </select>
          </div>
          
          <div class="checkbox-group">
            <input type="checkbox" id="cambiar_password" name="cambiar_password" onclick="togglePasswordFields()">
            <label for="cambiar_password">Cambiar contraseña</label>
          </div>
          
          <div id="password-fields" class="password-fields">
            <div class="form-group">
              <label for="password">Nueva contraseña:</label>
              <input type="password" id="password" name="password" minlength="6">
            </div>
            
            <div class="form-group">
              <label for="confirm_password">Confirmar nueva contraseña:</label>
              <input type="password" id="confirm_password" name="confirm_password" minlength="6">
            </div>
          </div>
          
          <button type="submit" class="btn-submit">Guardar Cambios</button>
          <a href="panel_moderador.php#usuarios" class="btn-back">Volver al panel</a>
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
    // Inicializar el estado de los campos de contraseña
    document.addEventListener('DOMContentLoaded', function() {
      togglePasswordFields();
    });
  </script>
</body>
</html>