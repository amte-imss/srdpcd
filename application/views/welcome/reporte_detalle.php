<!--link rel="stylesheet" href="<?php echo base_url(); ?>assets/tablero_tpl/css/jquery.fancybox.css" type="text/css" media="screen" />
<link href="<?php echo base_url(); ?>assets/tablero_tpl/css/isotope.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/tablero_tpl/css/style.css"-->

<?php
$fechas = "";
foreach ($cargas as $key_c => $carga) {
    $fechas .= "<tr>
            <td>".$carga['car_descripcion']."</td>
            <td class='text-center'>".date_format(date_create($carga['car_fecha_notificar']), 'd/m/Y')."</td>
            <td class='text-center'>".((is_null($carga['car_fecha_carga']) or empty($carga['car_fecha_carga']) or trim($carga['car_fecha_carga'])=='') ? '' : '<a href="'.site_url('welcome/reporte_detalle/'.encrypt_base64($carga['id_carga'])).'"><i class="fa fa-download" aria-hidden="true"></i> &nbsp;Descargar</a>')."</td>
        </tr>";
        //<td>".((is_null($carga['car_fecha_carga']) or empty($carga['car_fecha_carga']) or trim($carga['car_fecha_carga'])=='') ? '' : $carga['car_fecha_notificar'])."</td>
}
?>

<div class="cores-dashboard">
<div class="row">					
    <div class="wow bounceInRight">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h3 class="text-bold">Reporte de cursos a distancia</h3>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 text-right">
            <h6 class="text-bold">Fecha de última actualización: <b><?php echo nice_date($fecha_ultima_actualizacion[0]['fecha_actualizacion'], 'd-m-Y'); ?></b></h6>
            <h6 class="text-bold">Fecha de próxima actualización: <b><?php echo nice_date($fecha_siguiente_actualizacion[0]['fecha_proxima'], 'd-m-Y'); ?></b></h6>
        </div>
    </div>			
</div>	

<hr>
<!-- column content -->

<div class="row">
    <div class="big-box">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class='text-center'>Periodo comprendido del reporte</th>
                        <th class='text-center'>Fecha de publicación</th>
                        <th class='text-center'>Liga de descarga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $fechas; ?>
                </tbody>
            </table>
        </div>
    </div>					
</div>
</div>

<!-- end column content -->	