<?php
// Incluye el archivo de conexión a la base de datos
require_once 'conexion.php';

// Iniciamos la sesión para poder acceder a variables de sesión si se necesita en el futuro
session_start();

$mensaje_estado = ''; // Variable para almacenar mensajes de éxito o error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recopila y sanitiza los datos del formulario
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $comentario = filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $valoracion = filter_input(INPUT_POST, 'valoracion', FILTER_VALIDATE_INT);

    // Valida los datos (ejemplo básico)
    if (empty($nombre) || empty($correo) || empty($comentario)) {
        $mensaje_estado = "<p style='color: red;'>Por favor, rellena todos los campos obligatorios.</p>";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje_estado = "<p style='color: red;'>El formato del correo electrónico no es válido.</p>";
    } else {
        try {
            // Prepara la consulta SQL para insertar los datos
            $stmt = $conn->prepare("INSERT INTO contactos (nombre, correo, comentario, valoracion) VALUES (:nombre, :correo, :comentario, :valoracion)");

            // Asigna los valores a los parámetros
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':comentario', $comentario);
            // Si la valoración es nula o no es un número válido, se inserta NULL
            $stmt->bindParam(':valoracion', $valoracion, PDO::PARAM_INT);

            // Ejecuta la consulta
            if ($stmt->execute()) {
                $mensaje_estado = "<p style='color: green;'>¡Gracias! Tu comentario ha sido enviado.</p>";
                // Opcional: Limpiar el formulario después del envío exitoso
                $_POST = array(); 
            } else {
                $mensaje_estado = "<p style='color: red;'>Hubo un error al enviar tu comentario. Inténtalo de nuevo.</p>";
            }
        } catch (PDOException $e) {
            $mensaje_estado = "<p style='color: red;'>Error de base de datos: " . $e->getMessage() . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="conctato.css">
  <title>Aqua Pure - Contacto</title>
</head>
<body>

<?php include 'header.php'; ?>
  <main>
    <div class="contact-container">
      <h1 class="contact-heading">Contáctanos</h1>
      
      <div class="contact-content">
        <div class="contact-info">
          <h3>Información de Contacto</h3>
          
          <div class="info-item">
            <i class="fas fa-map-marker-alt"></i>
            <div>
              <p><strong>Dirección:</strong><br>
              Avenida del Agua 123<br>
              001289 Barranquilla, Colombia</p>
            </div>
          </div>
          
          <div class="info-item">
            <i class="fas fa-phone-alt"></i>
            <div>
              <p><strong>Teléfono:</strong><br>
              +57 302 252 7991</p>
            </div>
          </div>
          
          <div class="info-item">
            <i class="fas fa-envelope"></i>
            <div>
              <p><strong>Email:</strong><br>
              info@aquapure.es</p>
            </div>
          </div>
          
          <div class="info-item">
            <i class="fas fa-clock"></i>
            <div>
              <p><strong>Horario de Atención:</strong><br>
              Lunes a Viernes: 9:00 - 18:00<br>
              Sábados: 10:00 - 14:00</p>
            </div>
          </div>
        </div>
        
        <div class="contact-form-container">
          <h3>Escribir comentario</h3>
          
          <?php echo $mensaje_estado; // Muestra mensajes de estado aquí ?>

          <form class="comment-form" method="POST" action="contacto.php">
            <div class="form-row">
              <input type="text" class="form-control" name="nombre" placeholder="Nombre" required value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
              <input type="email" class="form-control" name="correo" placeholder="Correo electrónico (no se publicará)" required value="<?php echo isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : ''; ?>">
            </div>
            
            <div class="form-row">
              <textarea class="form-control" name="comentario" placeholder="Comentario o pregunta" rows="5" required><?php echo isset($_POST['comentario']) ? htmlspecialchars($_POST['comentario']) : ''; ?></textarea>
         
            </div>
            
            <div class="rating-stars">
              <span>Tu valoración:</span>
              <div class="stars" data-rating="0"> <span class="star" data-value="1">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="5">★</span>
              </div>
              <input type="hidden" name="valoracion" id="valoracion_input" value="0"> <span class="rating-value">Sin valoración</span>
            </div>
            
            <div class="privacy-check">
              <input type="checkbox" id="privacy" name="privacidad_aceptada" required>
              <label for="privacy">He leído y acepto la <a href="#" class="privacy-link">política de privacidad</a></label>
            </div>
            
            <button type="submit" class="submit-btn">Enviar comentario</button>
          </form>
        </div>
      </div>
      
      <div class="map-container">
        <iframe 
  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.228866177896!2d-74.80588378422877!3d10.97144026113702!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8ef42bd1429f3ef3%3A0x1c59d4abdd7f67f2!2sCl.%2059%20%2354-74%2C%20Barranquilla%2C%20Atl%C3%A1ntico!5e0!3m2!1ses!2sco!4v1717704000000!5m2!1ses!2sco" 
  width="100%" 
  height="450" 
  style="border:0;" 
  allowfullscreen="" 
  loading="lazy" 
  referrerpolicy="no-referrer-when-downgrade">
</iframe>

      </div>
    </div>
    
    <div class="meta-ods">
      <img src="ods6.png" alt="ODS 6 Logo" class="ods-logo">
      <img src="ods11.png" alt="ODS 11 Logo" class="ods-logo">
      <img src="ods12.png" alt="ODS 12 Logo" class="ods-logo">
      <p>Estas acciones están alineadas con el <strong>Objetivo de Desarrollo Sostenible 6</strong> de la ONU, que busca garantizar agua limpia y saneamiento para todos antes del 2030.</p>
    </div>
  </main>

<?php include 'footer.php'; ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
  
  <script>
    // Script para la funcionalidad de las estrellas de valoración
    document.addEventListener('DOMContentLoaded', function() {
      const starsContainer = document.querySelector('.rating-stars .stars');
      const stars = starsContainer.querySelectorAll('.star');
      const ratingValueSpan = document.querySelector('.rating-value');
      const valoracionInput = document.getElementById('valoracion_input');
      
      const ratingTexts = ['Muy malo', 'Malo', 'Más o menos', 'Bueno', 'Excelente'];
      
      // Función para actualizar la apariencia de las estrellas y el input oculto
      function updateStars(selectedRating) {
        stars.forEach((star, index) => {
          if (index < selectedRating) {
            star.classList.add('active');
          } else {
            star.classList.remove('active');
          }
        });
        valoracionInput.value = selectedRating;
        ratingValueSpan.textContent = selectedRating > 0 ? ratingTexts[selectedRating - 1] : 'Sin valoración';
      }

      // Inicializar las estrellas si hay un valor previo (útil si se recarga la página por un error PHP)
      const initialRating = parseInt(valoracionInput.value);
      if (initialRating > 0) {
        updateStars(initialRating);
      }

      stars.forEach((star) => {
        star.addEventListener('click', () => {
          const value = parseInt(star.dataset.value);
          updateStars(value);
        });

        star.addEventListener('mouseover', () => {
          const value = parseInt(star.dataset.value);
          stars.forEach((s, i) => {
            if (i < value) {
              s.classList.add('hover-active');
            } else {
              s.classList.remove('hover-active');
            }
          });
        });

        star.addEventListener('mouseout', () => {
          stars.forEach(s => s.classList.remove('hover-active'));
        });
      });
    });
  </script>

</body>
</html>