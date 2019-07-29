<?php
/*
 * Cuando escribí esto sólo Dios y yo sabíamos lo que hace.
 * Ahora, sólo Dios sabe.
 * Lo siento.
 */
$titulo = $asistentes;
$color = '#98c56e';
if($asistentes == 'Asistentes reales')
{
  $color = '#98c56e';
}else{
  if($asistentes == 'Asistentes programados')
  {
      $color = '#0095bc';
  }else{
      $color = '#f3b510';
  }
}
?>
<?php
if (empty($datos))
{
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#alert-ranking').css('display', 'block');
        });
    </script>
    <?php
} else
{
    ?>
    <script src="<?php echo base_url(); ?>assets/third-party/highcharts/highcharts.js"></script>
    <script src="<?php echo base_url(); ?>assets/third-party/highcharts/data.js"></script>
    <script src="<?php echo base_url(); ?>assets/third-party/highcharts/modules/exporting.js"></script>
    <div id="area_graph"></div>


    <?php echo js("chart_options.js"); ?>
    <?php
      if($ranking == 'dec')
      { ?>
        <script type="text/javascript">
            var titulo = "<?php echo $asistentes; ?>";
            if(titulo == 'Asistentes programados vs Asistentes aprobados')
            {
              $(document).ready(function () {
                  sortTable("table_ranking");
                  chart("area_graph", "table_ranking", titulo, titulo, ['#0095bc','#98c56e']);
              });
            }else{
              $(document).ready(function () {
                  sortTable("table_ranking");
                  chart("area_graph", "table_ranking", titulo, titulo, ['<?php echo $color; ?>']);
              });
            }

        </script>
      <?php
      }
      ?>
    <?php
}
?>
