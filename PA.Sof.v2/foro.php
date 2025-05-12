
<?php

// // Conexión a la base de datos (ajusta con tus datos)
// $conn = new mysqli("localhost", "tu_usuario", "tu_contraseña", "tu_base_datos");
// if ($conn->connect_error) {
//   die("Error de conexión: " . $conn->connect_error);
// }

// // Procesar formulario para insertar mensaje
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   $mensaje = trim($_POST["mensaje"]);
//   if (!empty($mensaje)) {
//     $usuario = isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : "Anónimo";
//     $stmt = $conn->prepare("INSERT INTO mensajes (usuario, contenido) VALUES (?, ?)");
//     $stmt->bind_param("ss", $usuario, $mensaje);
//     $stmt->execute();
//     $stmt->close();
//     header("Location: foro.php"); // Evita reenvío doble al recargar
//     exit();
//   }
// }
?> 


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aqua Pure - Foro de la Comunidad</title>
  <link rel="stylesheet" href="foro.css" />
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
      <div class="intro">
        <h1>Foro de la Comunidad</h1>
        <p>Comparte ideas, dudas y sugerencias con otros usuarios.</p>
      </div>

      <div class="foro-container">
        <div class="foro-mensajes" id="foro-mensajes">
          <?php
          $result = $conn->query("SELECT usuario, contenido FROM mensajes ORDER BY fecha ASC");
          while ($row = $result->fetch_assoc()) {
            echo "<div class='mensaje'><strong>" . htmlspecialchars($row["usuario"]) . ":</strong> " . htmlspecialchars($row["contenido"]) . "</div>";
          }
          ?>
        </div>

        <?php if (isset($_SESSION["usuario"])): ?>
        <form class="foro-form" method="POST" action="foro.php">
          <textarea name="mensaje" rows="3" placeholder="Escribe tu mensaje aquí..." required></textarea>
          <button type="submit">Enviar</button>
        </form>
        <?php else: ?>
          <p>Debes <a href="iniciarsesion.php">iniciar sesión</a> para publicar un mensaje.</p>
        <?php endif; ?>
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
