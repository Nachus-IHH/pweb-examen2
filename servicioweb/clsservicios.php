<?php

// EXAMEN UNIDAD II - PROGRAMACIÓN WEB
// INTEGRANTES DEL EQUIPO:
//   1. Hernandez Hernandez Ignacio  - 23200144
//   2. Lara Cruz Brandon Javier     - 23200146
//   3. Santiago Padilla Rubén       - 23200158

// NOMBRE DE LA CLASE
class clsservicios
{
    // ------------------------------------------------------------
    // CONEXIÓN ÚNICA: AQUÍ SE CAMBIA ENTRE LOCAL Y AWS (RDS)
    // ------------------------------------------------------------
    private function conectar()
    {
        // LOCAL (activa)
        $conn = mysqli_connect("127.0.0.1", "root", "root", "bd_almacen", 3307); 

        // AWS RDS (para EC2: comentar la línea LOCAL y descomentar esta)
        // $conn = mysqli_connect("dbprogweb.cypync26f8pv.us-east-1.rds.amazonaws.com", "admin", "ProgWeb_26.", "bd_almacen");

        if ($conn) {
            mysqli_set_charset($conn, "utf8mb4");
        }
        return $conn;
    }

    // Método para inicio de sesión / acceso
    public function sp_Acceso($usu, $pwd)
    {
        $datos = array();

        if ($conn = $this->conectar()) {

            $usu = mysqli_real_escape_string($conn, $usu);
            $pwd = mysqli_real_escape_string($conn, $pwd);

            $cmdSql  = "CALL sp_Acceso('$usu','$pwd');";
            $renglon = mysqli_query($conn, $cmdSql);

            if ($renglon && mysqli_num_rows($renglon) > 0) {
                while ($resultado = mysqli_fetch_assoc($renglon)) {
                    $datos[0]["BAN"] = $resultado["usu_ban"];
                    if ($datos[0]["BAN"] == "1") {
                        $datos[0]["CVE"] = $resultado["usu_cve_usuario"];
                        $datos[0]["NOM"] = $resultado["usu_nombre"];
                        $datos[0]["USU"] = $resultado["usu_usuario"];
                        $datos[0]["ROL"] = $resultado["rol_nombre"];
                    }
                }
            } else {
                $datos[0]["BAN"] = "0";
            }

            mysqli_close($conn);
        } else {
            $datos[0]["BAN"] = "-1"; // error de conexión
        }

        return $datos;
    }

    // Método principal del examen: ejecuta la vista de productos
    public function vwRptProducto()
    {
        $datos = array();

        if ($conn = $this->conectar()) {

            $renglon = mysqli_query($conn, "SELECT * FROM vwRtpProducto;");

            if ($renglon && mysqli_num_rows($renglon) > 0) {
                $i = 0;
                while ($resultado = mysqli_fetch_assoc($renglon)) {
                    $datos[$i]["BAN"] = "1";
                    $datos[$i]["CVE"] = $resultado["clave"];
                    $datos[$i]["NOM"] = $resultado["nombre"];
                    $datos[$i]["DES"] = $resultado["descripcion"];
                    $datos[$i]["PRE"] = $resultado["precio"];
                    $datos[$i]["CAN"] = $resultado["cantidad"];
                    $datos[$i]["ACT"] = $resultado["activo"];
                    $datos[$i]["FOT"] = $resultado["foto"];
                    $datos[$i]["EST"] = $resultado["estatus"];
                    $datos[$i]["FEC"] = $resultado["fecha_registro"];
                    $i++;
                }
            } else {
                $datos[0]["BAN"] = "0"; // sin registros
            }

            mysqli_close($conn);
        } else {
            $datos[0]["BAN"] = "-1"; // error de conexión
        }

        return $datos;
    }
}
