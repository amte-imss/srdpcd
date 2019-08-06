<!--link rel="stylesheet" href="<?php echo base_url(); ?>assets/tablero_tpl/css/jquery.fancybox.css" type="text/css" media="screen" />
<link href="<?php echo base_url(); ?>assets/tablero_tpl/css/isotope.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/tablero_tpl/css/style.css"-->

<?php
$fechas = "";
foreach ($cargas as $key_c => $carga) {
    $fechas .= "<tr>
            <td>".$carga['car_descripcion']."</td>
            <td>".((is_null($carga['car_fecha_carga']) or empty($carga['car_fecha_carga']) or trim($carga['car_fecha_carga'])=='') ? '' : '<a href="'.site_url('welcome/reporte_detalle').'"><i class="fa fa-download" aria-hidden="true"></i> &nbsp;Descargar</a>')."</td>
        </tr>";
        //<td>".((is_null($carga['car_fecha_carga']) or empty($carga['car_fecha_carga']) or trim($carga['car_fecha_carga'])=='') ? '' : $carga['car_fecha_notificar'])."</td>
}
?>

<div class="cores-dashboard">
<div class="row">					
    <div class="wow bounceInRight">	
        <div class="col-lg-12 col-md-12 col-sm-12 text-right">
            <h4 class="text-bold">Fecha de última actualización: <?php echo nice_date($fecha_ultima_actualizacion[0]['fecha_actualizacion'], 'd-m-Y'); ?></h4>
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
                        <th>Fecha</th>
                        <th>Liga de descarga</th>
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