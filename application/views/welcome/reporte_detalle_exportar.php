<div class="row">
    <div class="big-box">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Clave del curso</th>
                        <th>Nombre del curso</th>
                        <th>Fecha inicio del curso</th>
                        <th>Fecha fin de curso</th>
                        <th>Matrícula</th>
                        <th>Apellido paterno</th>
                        <th>Apellido materno</th>
                        <th>Nombre(s)</th>
                        <th>Categoría</th>
                        <th>Departamento / adscripción</th>
                        <th>Unidad</th>
                        <th>Delegación</th>
                        <th>Aprobado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $fechas = "";
                    foreach ($datos as $key_c => $dato) {
                        echo "<tr>
                                <td>".$dato['imal_clave_implementacion']."</td>
                                <td>".$dato['imal_curso']."</td>
                                <td>".nice_date($dato['imal_fecha_inicio_curso'], 'd-m-Y')."</td>
                                <td>".nice_date($dato['imal_fecha_fin_curso'], 'd-m-Y')."</td>
                                <td>".$dato['imal_matricula']."</td>
                                <td>".$dato['imal_apellido_paterno']."</td>
                                <td>".$dato['imal_apellido_materno']."</td>
                                <td>".$dato['imal_nombre']."</td>
                                <td>".$dato['imal_categoria']."</td>
                                <td>".$dato['imal_adscripcion']."</td>
                                <td>".$dato['imal_unidad']."</td>
                                <td>".$dato['imal_delegacion']."</td>
                                <td>".((is_null($dato['imal_folio_certificado']) or empty($dato['imal_folio_certificado']) or $dato['imal_folio_certificado']=="") ? ' ' : 'Aprobado')."</td>
                            </tr>";
                            //<td>".((is_null($carga['car_fecha_carga']) or empty($carga['car_fecha_carga']) or trim($carga['car_fecha_carga'])=='') ? '' : $carga['car_fecha_notificar'])."</td>
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>					
</div>
</div>

<!-- end column content -->	