<?php
// Iniciamos la sesión para poder acceder a variables de sesión si se necesita en el futuro
session_start();
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="comotrabajamos.css">
  <title>Aqua Pure - Cómo Trabajamos</title>
</head>

<body>
   <header>
    <?php include 'header.php'; ?>
  </header>

  <main>
    <div class="contenido">
      <section id="como-trabajamos">
        <h2>Cómo Trabajamos</h2>
        <img src="comoitrabajamos.png" alt="Comunidad participando en un taller de saneamiento de agua en Colombia" class="imagen-comotrabajamos" loading="lazy">
        <p>
          Nuestra metodología se basa en la investigación comunitaria, el diseño de software educativo y el análisis de datos.
          Creamos guías prácticas de saneamiento, facilitamos la participación ciudadana y evaluamos el impacto de nuestras acciones.
        </p>
        <p>
          Trabajamos mano a mano con comunidades locales para identificar sus necesidades hídricas específicas, utilizando encuestas, talleres y entrevistas. Este enfoque participativo asegura que nuestras soluciones sean culturalmente apropiadas y efectivas.
        </p>
        <p>
          Desarrollamos herramientas digitales, como aplicaciones móviles y plataformas web, para educar sobre el uso responsable del agua y el saneamiento. Estas herramientas están diseñadas para ser accesibles, incluso en áreas con conectividad limitada.
        </p>
        <p>
          A través del análisis de datos, monitoreamos la calidad del agua, el consumo y los resultados de nuestros proyectos. Esto nos permite medir el impacto, ajustar estrategias y compartir aprendizajes con otras organizaciones y comunidades.
        </p>
      </section>
    </div>
  </main>

<?php include 'footer.php'; ?>
</body>
</html>