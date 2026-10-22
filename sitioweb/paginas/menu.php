<?php
/*
 * Hernandez Hernandez Ignacio 23200144
 * Lara Cruza Brandon Javier 23200144
 * Santiago Padilla Rubén 23200158
 * */
// Detecta la página actual para marcar el link activo automáticamente
$current = basename($_SERVER['PHP_SELF']);
function isActive($page, $current) { return $page === $current ? 'active' : ''; }
?>
<!-- Bootstrap 5 (si ya lo cargas en tu layout, puedes quitar estas 2 líneas) -->
<!--<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" -->
<!--<link href="../bootstrap/css/bootstrap-icons.css" rel="stylesheet" -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm pf-nav">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="inicio.php">
      <span class="pf-logo d-inline-block"></span>
      <strong>Programación Web • ISC</strong>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#pfNavbar"
            aria-controls="pfNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="pfNavbar">
      <ul class="navbar-nav ms-auto align-items-lg-center mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link position-relative <?= isActive('inicio.php',$current) ?>" href="inicio.php">
            <i class="bi bi-house-door me-1"></i>Inicio
          </a>
        </li>

        <li class="nav-item">

<li class="nav-item">
    <?php if (isset($_SESSION['nomUsuario'])) { ?>

        <a class="nav-link position-relative"
           href="inicio.php?op=rptproducto">
            <i class="bi bi-bag me-1"></i>
            Productos Mercado Libre
        </a>

    <?php } else { ?>

        <a class="nav-link position-relative"
           href="inicio.php?op=acceso"
           onclick="alert('Acceso denegado. Debes iniciar sesión.');">
            <i class="bi bi-bag me-1"></i>
            Productos Mercado Libre
        </a>

    <?php } ?>
</li>

       <?php
          if (isset($_SESSION['nomUsuario'])) {

              // Obtener el rol guardado en sesión
              $rolUsuario = $_SESSION['rolUsuario'] ?? 'CLIENTE';

              // Imagen según el rol
              if ($rolUsuario === 'ADMINISTRADOR') {
                  $imagenUsuario = 'imagenes/usuarios/usuAdmin.png';
              } else {
                  // VENTAS y CLIENTE
                  $imagenUsuario = 'imagenes/usuarios/usuUser.png';
              }
          ?>

          <li class="nav-item">
              <a class="nav-link position-relative pf-user-session"
                href="inicio.php?op=cerrar"
                title="Cerrar sesión">

                  <img
                      src="<?php echo htmlspecialchars($imagenUsuario); ?>"
                      alt="Usuario"
                      class="pf-user-avatar"
                  >

                  <span class="pf-user-info">

                      <span class="pf-user-name">
                          <?php echo htmlspecialchars($_SESSION['nomUsuario']); ?>
                      </span>

                      <span class="pf-user-details">
                          (<?php echo htmlspecialchars($_SESSION['usuUsuario']); ?>
                          - 
                          <?php echo htmlspecialchars($rolUsuario); ?>)
                      </span>

                  </span>

              </a>
          </li>

          <?php
          } else {
          ?>

          <li class="nav-item">
              <a class="nav-link position-relative pf-user-session"
                href="inicio.php?op=acceso"
                title="Iniciar sesión">

                  <img
                      src="imagenes/usuarios/usuNoUser.png"
                      alt="Sin sesión"
                      class="pf-user-avatar"
                  >

                  <span class="pf-user-info">
                      <span class="pf-user-name">
                          Mi sesión
                      </span>
                  </span>

              </a>
          </li>

          <?php
          }
          ?>

        <li class="nav-item ms-lg-2">
          <a class="btn btn-gradient fw-semibold px-3" href="contacto.php">
            ¡Comencemos! <i class="bi bi-rocket-takeoff ms-1"></i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
  .pf-nav .nav-link {
    --underline: 0;
    transition: color .2s ease, transform .2s ease;
  }
  .pf-nav .nav-link:hover { transform: translateY(-1px); }
  .pf-nav .nav-link::after{
    content:""; position:absolute; left:.5rem; right:.5rem; bottom:.3rem; height:2px;
    background: linear-gradient(90deg, #22d3ee, #a78bfa);
    transform: scaleX(var(--underline)); transform-origin: right; transition: transform .25s ease;
    border-radius:2px;
  }
  .pf-nav .nav-link:hover::after { --underline: 1; transform-origin: left; }
  .pf-nav .nav-link.active { color: #fff !important; }
  .pf-nav .nav-link.active::after { --underline: 1; }

  /* Botón gradiente */
  .btn-gradient{
    background: linear-gradient(90deg, #22d3ee, #34d399);
    color:#0b1020; border: none; border-radius: .75rem;
    box-shadow: 0 8px 24px rgba(0,0,0,.25);
  }
  .btn-gradient:hover{ filter: brightness(1.07); }

  /* Logo animado */
  .pf-logo{
    width: 30px; height: 30px; border-radius: 10px;
    background: conic-gradient(from 180deg at 50% 50%, #22d3ee, #a78bfa, #34d399, #22d3ee);
    box-shadow: inset 0 0 8px rgba(255,255,255,.25), 0 6px 16px rgba(0,0,0,.35);
    animation: pfspin 12s linear infinite;
  }
  @keyframes pfspin { to { transform: rotate(360deg);} }

  /* =========================================
   USUARIO / SESIÓN
   ========================================= */

.pf-user-session {
    display: inline-flex !important;
    align-items: center;
    gap: 8px;
    padding-top: 5px !important;
    padding-bottom: 5px !important;
}

.pf-user-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    object-fit: cover;
    background: #ffffff;
    border: 2px solid rgba(255, 255, 255, 0.7);
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.25);
    flex-shrink: 0;
}

.pf-user-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    line-height: 1.2;
}

.pf-user-name {
    font-size: 14px;
    font-weight: 600;
    color: #ffffff;
}

.pf-user-details {
    font-size: 11px;
    color: #cbd5e1;
    margin-top: 2px;
}

</style>
<!-- Bootstrap JS (si ya lo cargas en tu layout, puedes quitar esta línea) -->
<!-- <script src="../bootstrap/js/bootstrap.bundle.min.js"></script -->

