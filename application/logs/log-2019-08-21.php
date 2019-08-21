<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-08-21 15:55:54 --> Severity: Warning --> Missing argument 1 for Welcome::reporte_detalle() C:\xampp\htdocs\2019\srdpcd\application\controllers\Welcome.php 160
ERROR - 2019-08-21 15:55:54 --> Severity: Notice --> Undefined variable: id C:\xampp\htdocs\2019\srdpcd\application\controllers\Welcome.php 169
ERROR - 2019-08-21 15:55:54 --> Query error: ERROR:  column "NULL" does not exist
LINE 3: WHERE "id_carga" = "NULL" AND "imal_externo" = false AND "im...
                           ^ - Invalid query: SELECT "imal_clave_implementacion", "imal_curso", "imal_fecha_inicio_curso", "imal_fecha_fin_curso", "imal_matricula", "imal_apellido_paterno", "imal_apellido_materno", "imal_nombre", "imal_categoria", "imal_unidad", "imal_delegacion", "imal_folio_certificado"
FROM "srdpcd"."implementaciones_alumnos" "IMAL"
WHERE "id_carga" = "NULL" AND "imal_externo" = false AND "imal_guarderias" = false AND "imal_imss_oportunidades" IS NULL AND "imal_clave_delegacion" <> '09'
ORDER BY "imal_clave_implementacion", "imal_fecha_inicio_curso", "imal_fecha_fin_curso"
