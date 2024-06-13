<!DOCTYPE html>
<html lang="es">
<head>
  <!-- Metadatos -->
  <meta charset="UTF-8">
  <meta name="author" content="Gerson Giraldo">
  <meta name="description" content="Página de inicio de software-CICLO">
  <meta name="keywords" content="HTML, CSS">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- Iconos de Bootstrap-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
  <!-- titulo -->
  <title><?= NOMBRE_SITIO ?></title>
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?= URL_PATH ?>/Assets/images/Logo-CICLO.jpg">
  <!-- CSS -->
  <link href="<?= URL_PATH ?>/Assets/css/styles.css" rel="stylesheet" type="text/css">
  <!-- Google fonts-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&family=Rubik+Dirt&display=swap" rel="stylesheet">
  <script>
    var URL_PATH = '<?= URL_PATH ?>'; //Esta variable tiene el valor de '/Proyecto-SENA/public'
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
  <!-- Barra de navegación -->
  <nav class="navbar bg-dark navbar-expand-lg navbar-static fixed-top" data-bs-theme="dark">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-toggler" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar-toggler">
        <a class="navbar-brand" href="#hero">Software-CICLO</a>
        <ul class="navbar-nav d-flex justify-content-center align-items-center">
          <li class="nav-item">
            <a class="nav-link inicio" href="#hero">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link acerca-de" href="#acerca_de">Acerca de</a>
          </li>
          <li class="nav-item">
            <a class="nav-link servicios" href="#servicios">Servicios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link contacto" href="#contacto">Contacto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link Acceder/Registrarse" href="#Acceder/Registrarse">Acceder/Registrarse</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Fin barra de navegación -->
  <!--Vistas-->
  <?php echo $content; ?>
  <!--Fin vistas-->
  <!-- Contacto -->
  <section id="contacto" class="contacto seccion-oscura">
    <div class="container">
      <div class="container text-center rectangulo d-flex justify-content-evenly">
        <div class="row">
          <div class="col-12 col-md-4 seccion-titulo">
            ¡Hablemos!
          </div>
          <div class="col-12 col-md-4 descripcion">
            Contáctame y de inmediato te damos asesoria personalizada.
          </div>
          <div class="col-12 col-md-4">
            <a href="mailto:jazz.drums@hotmail.com">
              <button type="button">
                Contacto
                <i class="bi bi-envelope-check-fill"></i>
              </button>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Fin contacto -->
  <!-- Footer-->
  <footer class="seccion-oscura d-flex flex-column align-items-center justify-content-center">
    <img class="footer-logo rounded-circle" src="<?= URL_PATH ?>/Assets/images/Logo-CICLO.jpg" alt="Logo-footer">
    <p class="footer-texto text-center">
      Toma el control.<br>Creemos un proyecto juntos.
    </p>
    <div class="iconos-redes-sociales d-flex flex-wrap align-items-center justify-content-center">
      <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer">
        <i class="bi bi-instagram"></i>
      </a>
      <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer">
        <i class="bi bi-facebook"></i>
      </a>
      <a href="mailto:jazz.drums@hotmail.com" target="_blank" rel="noopener noreferrer">
        <i class="bi bi-envelope"></i>
      </a>
    </div>
    <div class="derechos-de-autor">Creado por Jerson Giraldo (2023) &#169;</div>
  </footer>
  <!-- Fin footer-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="<?= URL_PATH ?>/Assets/js/scripts.js"></script>
  <script src="<?= URL_PATH ?>/Assets/js/main.js"></script>
</body>
</html>