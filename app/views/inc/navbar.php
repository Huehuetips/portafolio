<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-sticky">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <a class="navbar-brand" href="<?php echo APP_URL; ?>">
        <img src="<?php echo APP_LOGO; ?>" alt="COCA-COLA" alt="" width="" height="45" class="d-inline-block align-text-top">
      </a>
      <a class="nav-link active" aria-current="page" href="<?php echo APP_URL; ?>#about">INICIO</a>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo APP_URL; ?>#experience">EXPERIENCIA</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo APP_URL; ?>#projects">PROYECTOS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo APP_URL; ?>#skills">HABILIDADES</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo APP_URL; ?>#contact">CONTACTO</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<div class="progress-nav"></div>
<?php include_once "app/views/inc/ext/rubick.php" ?>


