<?php
/*
 * Hernandez Hernandez Ignacio - 23200144
 * Lara Cruz Brandon Javier - 23200146
 * Santiago Padilla Rubén - 23200158
*/
    // session_start();
    session_unset();    // limpiar vars session
    session_destroy();  // destruye vars session

    echo "
        <script language='javascript'>document.location.href='inicio.php?op=acceso';</script>
    ";
?>
