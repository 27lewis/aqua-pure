<?php
require_once 'conexion.php';
session_start();

// Verificar si es moderador
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'moderador') {
    header('Location: iniciarsesion.php');
    exit();
}

$hilo_id = $_GET['id'] ?? 0;

// Obtener el hilo
$stmt = $conn->prepare("
    SELECT f.id, f.titulo, f.contenido, u.nombre as autor, f.fecha_creacion 
    FROM foro_hilos f 
    JOIN usuarios u ON f.usuario_id = u.id 
    WHERE f.id = ?
");
$stmt->execute([$hilo_id]);
$hilo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$hilo) {
    header('Location: panel_moderador.php#foro');
    exit();
}

// Procesar respuesta
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contenido = trim($_POST['contenido']);
    
    if (empty($contenido)) {
        $error = 'La respuesta no puede estar vacía.';
    } else {
        try {
            $stmt = $conn->prepare("
                INSERT INTO foro_respuestas (hilo_id, usuario_id, contenido, es_moderador) 
                VALUES (?, ?, ?, TRUE)
            ");
            $stmt->execute([$hilo_id, $_SESSION['user_id'], $contenido]);
            
            $success = 'Respuesta publicada correctamente.';
        } catch (PDOException $e) {
            $error = 'Error al publicar la respuesta: ' . $e->getMessage();
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
  <title>Aqua Pure - Responder Hilo</title>
  <style>
    .hilo-container {
      max-width: 800px;
      margin: 0 auto;
    }
    
    .hilo-header {
      background-color: #007B7F;
      color: white;
      padding: 15px;
      border-radius: 5px 5px 0 0;
    }
    
    .hilo-body {
      background-color: #f9f9f9;
      padding: 20px;
      border: 1px solid #ddd;
      border-top: none;
      border-radius: 0 0 5px 5px;
      margin-bottom: 30px;
    }
    
    .hilo-meta {
      display: flex;
      justify-content: space-between;
      margin-bottom: 15px;
      font-size: 0.9rem;
      color: #666;
    }
    
    .form-respuesta {
      margin-top: 30px;
    }
    
    .form-respuesta textarea {
      width: 100%;
      min-height: 150px;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      margin-bottom: 15px;
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
      <h2>Responder Hilo: <?php echo htmlspecialchars($hilo['titulo']); ?></h2>
      
      <?php if ($error): ?>
        <div class="error-message" style="color: red; margin-bottom: 15px;"><?php echo $error; ?></div>
      <?php endif; ?>
      
      <?php if ($success): ?>
        <div class="success-message" style="color: green; margin-bottom: 15px;"><?php echo $success; ?></div>
      <?php endif; ?>
      
      <div class="hilo-container">
        <div class="hilo-header">
          <h3><?php echo htmlspecialchars($hilo['titulo']); ?></h3>
        </div>
        
        <div class="hilo-body">
          <div class="hilo-meta">
            <span>Autor: <?php echo htmlspecialchars($hilo['autor']); ?></span>
            <span>Fecha: <?php echo date('d/m/Y H:i', strtotime($hilo['fecha_creacion'])); ?></span>
          </div>
          
          <div class="hilo-contenido">
            <p><?php echo nl2br(htmlspecialchars($hilo['contenido'])); ?></p>
          </div>
        </div>
      </div>
      
      <div class="form-respuesta">
        <h3>Escribe tu respuesta como moderador</h3>
        <form method="post">
          <textarea name="contenido" placeholder="Escribe tu respuesta aquí..." required></textarea>
          <button type="submit" class="btn-submit">Publicar Respuesta</button>
          <a href="panel_moderador.php#foro" class="btn-back">Volver al panel</a>
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