-- Hernandez Hernandez Ignacio - 23200144
-- Lara Cruz Brandon Javier - 23200146
-- Santiago Padilla Rubén - 23200158

CREATE DATABASE bd_almacen;
USE bd_almacen;

CREATE TABLE IF NOT EXISTS rol (
    rol_cve_rol     INT AUTO_INCREMENT PRIMARY KEY,
    rol_nombre      VARCHAR(30)  NOT NULL,
    rol_descripcion VARCHAR(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS usuario (
    usu_cve_usuario      INT AUTO_INCREMENT PRIMARY KEY, 
    usu_nombre           VARCHAR(30) NOT NULL,
    usu_apellido_paterno VARCHAR(30) NOT NULL,
    usu_apellido_materno VARCHAR(30) NOT NULL,
    usu_telefono         VARCHAR(15),
    usu_correo           VARCHAR(50),
    usu_fecha_registro   DATETIME    NOT NULL,
    usu_usuario          VARCHAR(15) NOT NULL,
    usu_password         VARCHAR(15) NOT NULL,
    rol_cve_rol          INT         NOT NULL,
    CONSTRAINT fk_usuario_rol FOREIGN KEY (rol_cve_rol) REFERENCES rol(rol_cve_rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS producto (
    PRO_CVE INT AUTO_INCREMENT PRIMARY KEY,
    PRO_NOMBRE VARCHAR(100) NOT NULL,
    PRO_DESCRIPCION VARCHAR(255),
    PRO_PRECIO DECIMAL(10,2) NOT NULL,
    PRO_CANTIDAD INT NOT NULL DEFAULT 0,
    PRO_ACTIVO TINYINT(1) NOT NULL DEFAULT 1,
    PRO_FOTO VARCHAR(255),
    PRO_ESTATUS VARCHAR(30) NOT NULL DEFAULT 'DISPONIBLE',
    PRO_FECHA_REGISTRO DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Procedimientos
DELIMITER //

CREATE PROCEDURE sp_Acceso
(
    IN p_usuario VARCHAR(15),
    IN p_password VARCHAR(15)
)
BEGIN
    IF EXISTS (
        SELECT 1
        FROM usuario u
        INNER JOIN rol r ON u.rol_cve_rol = r.rol_cve_rol
        WHERE u.usu_usuario = p_usuario
          AND u.usu_password = p_password
    ) THEN

        SELECT
            '1' AS usu_ban,
            u.usu_cve_usuario,
            CONCAT(
                u.usu_nombre, ' ',
                u.usu_apellido_paterno, ' ',
                u.usu_apellido_materno
            ) AS usu_nombre,
            u.usu_usuario,
            r.rol_nombre
        FROM usuario u
        INNER JOIN rol r
            ON u.rol_cve_rol = r.rol_cve_rol
        WHERE u.usu_usuario = p_usuario
          AND u.usu_password = p_password;

    ELSE

        SELECT '0' AS usu_ban;

    END IF;
END //

DELIMITER ;

-- Vista

CREATE VIEW vwRtpProducto AS
SELECT
    PRO_CVE            AS clave,
    PRO_NOMBRE         AS nombre,
    PRO_DESCRIPCION    AS descripcion,
    PRO_PRECIO         AS precio,
    PRO_CANTIDAD       AS cantidad,
    PRO_ACTIVO         AS activo,
    PRO_FOTO           AS foto,
    PRO_ESTATUS        AS estatus,
    PRO_FECHA_REGISTRO AS fecha_registro
FROM producto;

SELECT * FROM vwRtpProducto;
