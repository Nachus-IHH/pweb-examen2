<?php
/*
sitioweb/config_soap.php

Hernandez Hernandez Ignacio  - 23200144
Lara Cruz Brandon Javier     - 23200146
Santiago Padilla Rubén       - 23200158
*/
try {
    return new SoapClient(null, [
        'location' => 'http://localhost/prog-web/examen2/servicioweb/servicioweb.php',
        'uri' => 'http://localhost/',
        'connection_timeout' => 10,
        'exceptions' => true
    ]);
} catch (SoapFault $e) {
    die("Error al conectar con el servidor SOAP: " . $e->getMessage());
}

