<?php
/*
 * Hernandez Hernandez Ignacio - 23200144
 * Lara Cruz Brandon Javier - 23200146
 * Santiago Padilla Rubén - 23200158
 * */
// Seguridad: solo usuarios con sesión iniciada.

$cliente = require 'config_soap.php';

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
        max-width: 1500px;
        width: 96%;
        margin: 0 auto;
        padding: 25px 0 15px;
    }

    .ml-encabezado {
        background: #FFE600;
        border-radius: 12px;
        padding: 22px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
    }

    .ml-encabezado h1 {
        color: #333333;
        font-size: 28px;
        font-weight: 750;
        margin: 0;
    }

    .ml-encabezado p {
        color: #333333;
        margin: 5px 0 0;
    }

    .ml-marca {
        width: 90px;
        height: 65px;
        object-fit: contain;
    }

    .ml-subtitulo {
        color: #555555;
        margin-bottom: 20px;
    }

    .ml-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 14px;
    }

    .ml-card {
        min-width: 0;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e5e5e5;
        border-radius: 10px;
        box-shadow: 0 2px 7px rgba(0, 0, 0, .06);
        transition: transform .2s, box-shadow .2s;
    }

    .ml-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 7px 18px rgba(0, 0, 0, .12);
    }

    .ml-foto-link {
        height: 155px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
        background: #ffffff;
        border-bottom: 1px solid #eeeeee;
    }

    .ml-foto {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .ml-info {
        padding: 12px;
    }

    .ml-clave {
        font-size: 12px;
        color: #777777;
        margin-bottom: 6px;
    }

    .ml-nombre {
        color: #333333;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 8px;
        overflow-wrap: anywhere;
    }

    .ml-descripcion {
        color: #666666;
        font-size: 13px;
        min-height: 55px;
        overflow-wrap: anywhere;
    }

    .ml-precio {
        color: #222222;
        font-size: 21px;
        font-weight: 700;
        margin-top: 10px;
    }

    .ml-vacio, .ml-error {
        padding: 22px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 20px;
    }

    .ml-vacio {
        background: #f5f5f5;
        color: #555555;
    }

    .ml-error {
        background: #fff0f0;
        color: #a32020;
    }

    @media (max-width: 1200px) {
        .ml-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media (max-width: 850px) {
        .ml-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 550px) {
        .ml-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .ml-foto-link {
            height: 125px;
        }

        .ml-encabezado h1 {
            font-size: 23px;
        }

        .ml-precio {
            font-size: 18px;
        }
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

    <p class="ml-subtitulo">
        Productos registrados: <?php echo count($datos); ?>
    </p>

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

        <div class="ml-grid">

            <?php foreach ($datos as $producto) { ?>

                <?php
                $clave = $producto["CVE"] ?? '';
                $nombre = $producto['NOM'] ?? 'Producto';
                $descripcion = $producto['DES'] ?? '';
                $precio = (float) ($producto['PRE'] ?? 0);
                $foto = trim($producto['FOT'] ?? '');

                // Si MySQL guarda solamente el nombre del archivo,
                // agregar la carpeta donde se encuentran las imágenes.
                if ($foto !== '' && strpos($foto, '/') === false) {
                    $foto = 'imagenes/productos/' . $foto;
                }

                // Si no hay fotografía registrada, no inventar una ruta.
                $tieneFoto = $foto !== '';
                ?>

                <article class="ml-card">

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
                            $<?php echo number_format($precio, 2); ?>
                        </div>

                    </div>
                </article>

            <?php } ?>

        </div>

    <?php } ?>
</div>
