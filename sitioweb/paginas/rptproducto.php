<?php
/*
 * Hernandez Hernandez Ignacio - 23200144
 * Lara Cruz Brandon Javier - 23200146
 * Santiago Padilla Rubén - 23200158
 * */
// Seguridad: solo usuarios con sesión iniciada.

$cliente = require 'config_soap.php';
// Seguridad: solo usuarios con sesión iniciada.
if (!isset($_SESSION['nomUsuario'])) {
    echo "<script>
        alert('Acceso denegado. Debes iniciar sesión.');
        window.location.href='inicio.php?op=acceso';
    </script>";
    exit;
}

$datos = [];
$errorProductos = '';

try {
    $respuesta = $cliente->vwRptProducto();

    if (is_array($respuesta)) {
        $datos = $respuesta;
    } elseif (is_object($respuesta)) {
        $datos = (array) $respuesta;
    }

} catch (SoapFault $e) {
    error_log('SOAP Mercado Libre: ' . $e->getMessage());
    $errorProductos = 'No fue posible consultar los productos. Verifica el servicio web.';
}
?>

<style>
    .ml-catalogo {
        --ml-amarillo: #FFE600;
        --ml-azul: #3483FA;
        --ml-texto: #2b2b2b;
        --ml-gris: #6b6b6b;
        max-width: 1500px;
        width: 96%;
        margin: 0 auto;
        padding: 25px 0 15px;
    }

    /* ---------- ENCABEZADO ---------- */
    .ml-encabezado {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #FFE600 0%, #FFD500 60%, #FFC800 100%);
        border-radius: 18px;
        padding: 30px 32px;
        margin-bottom: 26px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
        box-shadow: 0 8px 24px rgba(255, 200, 0, .35);
    }

    /* círculos decorativos */
    .ml-encabezado::before,
    .ml-encabezado::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, .25);
        pointer-events: none;
    }

    .ml-encabezado::before { width: 220px; height: 220px; top: -90px; right: 120px; }
    .ml-encabezado::after  { width: 130px; height: 130px; bottom: -60px; left: 38%; }

    .ml-encabezado > * { position: relative; z-index: 1; }

    .ml-encabezado h1 {
        color: var(--ml-texto);
        font-size: 34px;
        font-weight: 800;
        letter-spacing: -.5px;
        margin: 0;
    }

    .ml-encabezado p {
        color: var(--ml-texto);
        opacity: .8;
        margin: 6px 0 0;
        font-size: 16px;
    }

    .ml-marca {
        width: 100px;
        height: 72px;
        object-fit: contain;
        background: #fff;
        padding: 8px;
        border-radius: 14px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .12);
    }

    /* ---------- BARRA: CONTADOR + BUSCADOR ---------- */
    .ml-barra {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }

    .ml-subtitulo {
        color: var(--ml-gris);
        margin: 0;
        font-size: 15px;
    }

    .ml-subtitulo strong {
        color: var(--ml-texto);
        background: #fff7a8;
        padding: 2px 10px;
        border-radius: 20px;
    }

    .ml-buscador {
        flex: 0 1 380px;
        width: 100%;
        padding: 11px 18px;
        border: 1px solid #ddd;
        border-radius: 30px;
        font-size: 14px;
        outline: none;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        transition: border-color .2s, box-shadow .2s;
    }

    .ml-buscador:focus {
        border-color: var(--ml-azul);
        box-shadow: 0 0 0 4px rgba(52, 131, 250, .15);
    }

    /* ---------- GRID ---------- */
    .ml-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 18px;
    }

    .ml-card {
        min-width: 0;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #ececec;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
        transition: transform .25s ease, box-shadow .25s ease, border-color .25s;
        animation: ml-aparece .5s ease both;
    }

    .ml-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 30px rgba(0, 0, 0, .14);
        border-color: var(--ml-amarillo);
    }

    @keyframes ml-aparece {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .ml-foto-link {
        position: relative;
        height: 185px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 14px;
        background: radial-gradient(circle at center, #ffffff 40%, #f6f6f6 100%);
        border-bottom: 1px solid #f0f0f0;
        color: #aaa;
        font-size: 13px;
        text-decoration: none;
    }

    .ml-foto {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform .3s ease;
    }

    .ml-card:hover .ml-foto {
        transform: scale(1.08);
    }

    /* texto "Ver imagen" al pasar el mouse */
    a.ml-foto-link::after {
        content: "🔍 Ver imagen";
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translate(-50%, 8px);
        background: var(--ml-azul);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        opacity: 0;
        transition: opacity .25s, transform .25s;
        white-space: nowrap;
    }

    .ml-card:hover a.ml-foto-link::after {
        opacity: 1;
        transform: translate(-50%, 0);
    }

    /* ---------- INFO ---------- */
    .ml-info {
        padding: 14px 16px 18px;
    }

    .ml-clave {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .4px;
        text-transform: uppercase;
        color: var(--ml-azul);
        background: #eaf2ff;
        padding: 3px 9px;
        border-radius: 20px;
        margin-bottom: 9px;
    }

    .ml-nombre {
        color: var(--ml-texto);
        font-size: 16px;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 6px;
        overflow-wrap: anywhere;
    }

    .ml-descripcion {
        color: var(--ml-gris);
        font-size: 13px;
        line-height: 1.45;
        min-height: 56px;
        overflow-wrap: anywhere;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .ml-precio {
        color: var(--ml-texto);
        font-size: 26px;
        font-weight: 700;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px dashed #e3e3e3;
    }

    .ml-precio sup {
        font-size: 13px;
        font-weight: 600;
        margin-left: 2px;
        position: relative;
        top: -3px;
    }

    /* ---------- ESTADOS ---------- */
    .ml-vacio, .ml-error, .ml-sin-resultados {
        padding: 30px;
        border-radius: 14px;
        text-align: center;
        margin-bottom: 20px;
    }

    .ml-vacio, .ml-sin-resultados {
        background: #f5f5f5;
        color: #555555;
    }

    .ml-sin-resultados { display: none; }

    .ml-error {
        background: #fff0f0;
        color: #a32020;
        border: 1px solid #f5c2c2;
    }

    /* ---------- PIE ---------- */
    .ml-pie-equipo {
        text-align: center;
        background: linear-gradient(135deg, #333333, #1f1f1f);
        color: #ffffff;
        border-radius: 16px;
        padding: 24px 12px;
        margin-top: 40px;
        line-height: 1.8;
        border-bottom: 4px solid var(--ml-amarillo);
    }

    .ml-pie-equipo h3 {
        font-size: 16px;
        margin-bottom: 8px;
    }

    .ml-pie-equipo p {
        font-size: 13px;
        margin: 0;
    }

    /* ---------- RESPONSIVE ---------- */
    @media (max-width: 550px) {
        .ml-encabezado { padding: 22px 18px; }
        .ml-encabezado h1 { font-size: 25px; }
        .ml-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
        .ml-foto-link { height: 130px; }
        .ml-precio { font-size: 21px; }
        .ml-buscador { flex-basis: 100%; }
    }
</style>

<div class="ml-catalogo">

    <header class="ml-encabezado">
        <div>
            <h1>Mercado Libre</h1>
            <p>Encuentra los productos de nuestro catálogo</p>
        </div>

        <img
            class="ml-marca"
            src="imagenes/productos/mercadolibre.jpg"
            alt="Imagen de Mercado Libre"
        >
    </header>

    <div class="ml-barra">
        <p class="ml-subtitulo">
            Productos registrados: <strong id="mlContador"><?php echo count($datos); ?></strong>
        </p>

        <?php if (!empty($datos)) { ?>
            <input
                type="search"
                id="mlBuscador"
                class="ml-buscador"
                placeholder="🔎 Buscar producto..."
                autocomplete="off"
            >
        <?php } ?>
    </div>

    <?php if ($errorProductos !== '') { ?>

        <div class="ml-error">
            <?php echo htmlspecialchars($errorProductos); ?>
        </div>

    <?php } elseif (empty($datos)) { ?>

        <div class="ml-vacio">
            No hay productos para mostrar. Verifica que existan registros
            en la tabla producto de bd_almacen.
        </div>

    <?php } else { ?>

        <div class="ml-sin-resultados" id="mlSinResultados">
            No se encontraron productos con esa búsqueda.
        </div>

        <div class="ml-grid">

            <?php foreach ($datos as $producto) { ?>

                <?php
                $clave = $producto['PRO_CVE'] ?? '';
                $nombre = $producto['PRO_NOMBRE'] ?? 'Producto';
                $descripcion = $producto['PRO_DESCRIPCION'] ?? '';
                $precio = (float) ($producto['PRO_PRECIO'] ?? 0);
                $foto = trim($producto['PRO_FOTO'] ?? '');

                // Si MySQL guarda solamente el nombre del archivo,
                // agregar la carpeta donde se encuentran las imágenes.
                if ($foto !== '' && strpos($foto, '/') === false) {
                    $foto = 'imagenes/productos/' . $foto;
                }

                // Si no hay fotografía registrada, no inventar una ruta.
                $tieneFoto = $foto !== '';

                // Precio separado: entero y centavos (para mostrar los centavos pequeños).
                $partesPrecio = explode('.', number_format($precio, 2, '.', ','));

                // Texto en minúsculas para el buscador.
                $busqueda = mb_strtolower($clave . ' ' . $nombre . ' ' . $descripcion, 'UTF-8');
                ?>

                <article
                    class="ml-card"
                    data-busqueda="<?php echo htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8'); ?>"
                >

                    <?php if ($tieneFoto) { ?>

                        <a
                            class="ml-foto-link"
                            href="<?php echo htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            title="Ver imagen completa de <?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>"
                        >
                            <img
                                class="ml-foto"
                                src="<?php echo htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>"
                                alt="<?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>"
                                loading="lazy"
                            >
                        </a>

                    <?php } else { ?>

                        <div class="ml-foto-link">
                            Sin fotografía
                        </div>

                    <?php } ?>

                    <div class="ml-info">

                        <div class="ml-clave">
                            Clave: <?php echo htmlspecialchars((string)$clave); ?>
                        </div>

                        <div class="ml-nombre">
                            <?php echo htmlspecialchars($nombre); ?>
                        </div>

                        <div class="ml-descripcion">
                            <?php echo htmlspecialchars($descripcion); ?>
                        </div>

                        <div class="ml-precio">
                            $<?php echo $partesPrecio[0]; ?><sup><?php echo $partesPrecio[1]; ?></sup>
                        </div>

                    </div>
                </article>

            <?php } ?>

        </div>

    <?php } ?>

</div>

<script>
    // Buscador en vivo (filtra por clave, nombre y descripción).
    (function () {
        var buscador = document.getElementById('mlBuscador');
        if (!buscador) return;

        var tarjetas = document.querySelectorAll('.ml-card');
        var contador = document.getElementById('mlContador');
        var sinResultados = document.getElementById('mlSinResultados');

        buscador.addEventListener('input', function () {
            var texto = buscador.value.trim().toLowerCase();
            var visibles = 0;

            tarjetas.forEach(function (tarjeta) {
                var coincide = tarjeta.dataset.busqueda.indexOf(texto) !== -1;
                tarjeta.style.display = coincide ? '' : 'none';
                if (coincide) visibles++;
            });

            contador.textContent = visibles;
            sinResultados.style.display = visibles === 0 ? 'block' : 'none';
        });
    })();
</script>
