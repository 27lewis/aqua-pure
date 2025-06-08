<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Aqua Pure - Conoce dónde trabajamos para promover el acceso al agua potable en comunidades rurales y municipios con escasez en Colombia, incluyendo Barranquilla y Santa Marta.">
  <meta name="keywords" content="Aqua Pure, dónde trabajamos, agua, sostenibilidad, Colombia, Caribe">
  <meta property="og:title" content="Aqua Pure - Dónde Trabajamos">
  <meta property="og:description" content="Explora nuestro impacto en comunidades rurales y municipios con escasez de agua en Colombia, enfocados en regiones como Barranquilla, Santa Marta y el Caribe.">
  <meta property="og:image" content="https://yourdomain.com/images/og-image.jpg">
  <link rel="stylesheet" href="dondetrabajamos.css">
  <title>Aqua Pure - Dónde Trabajamos</title>
</head>
<body>
<?php include 'header.php'; ?>

  <main>
    <div class="contenido">
      <section id="donde-trabajamos">
        <h2>Dónde Trabajamos</h2>
        <img src="dondetrabajamos.png" alt="Comunidad rural en la región Caribe de Colombia accediendo a agua potable" class="imagen-dondetrabajamos" loading="lazy">
        <p>
          Actualmente enfocamos nuestras acciones en comunidades rurales y municipios con escasez de agua en Colombia, 
          incluyendo zonas vulnerables de Barranquilla, Santa Marta y otras regiones del Caribe.
        </p>
        <p>
          En el Caribe colombiano, enfrentamos desafíos como la sequía estacional, la contaminación de fuentes hídricas y la falta de infraestructura de saneamiento. Nuestros proyectos en Barranquilla y Santa Marta incluyen la instalación de sistemas de recolección de agua lluvia y filtros comunitarios.
        </p>
        <p>
          También trabajamos en municipios como La Guajira, donde la escasez de agua afecta a comunidades indígenas Wayúu. Aquí, implementamos soluciones sostenibles como pozos solares y talleres de capacitación en gestión hídrica.
        </p>
        <p>
          Nuestro objetivo es expandir nuestro alcance a otras regiones de Colombia, como el Chocó y el Amazonas, para abordar problemas de acceso al agua potable y promover la resiliencia climática en comunidades vulnerables.
        </p>
      </section>
    </div>
  </main>

<?php include 'footer.php'; ?>
</body>
</html>