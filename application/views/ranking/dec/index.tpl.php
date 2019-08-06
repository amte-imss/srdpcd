<script src="<?php echo base_url(); ?>assets/third-party/highcharts/highcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/third-party/highcharts/data.js"></script>
<script src="<?php echo base_url(); ?>assets/third-party/highcharts/modules/exporting.js"></script>
<?php echo js("chart_options.js"); ?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div id="filtros_capa_header" class="card-header" data-background-color="green" data-toggle="collapse" data-target="#filtros_capa">
                <a href="#" data-toggle="collapse" data-target="#filtros_capa">Filtros<i class="fa fa-arrow-right pull-right" aria-hidden="true"></i><!-- <div class="material-icons pull-right">keyword_arrow_right</div> -->
                </a>
            </div>
            <?php
            echo js('ranking/continua/index.js');
            echo form_open('ranking/continua', array('id' => 'form_ranking'));
            ?>
            <div id="filtros_capa" class="card-content">
                <?php
                if(isset($lista_filtros) && $lista_filtros)
                {
                    foreach ($filtros as $key => $value)
                    {
                        echo $value;
                        echo '<br>';
                    }
                }
                if (is_nivel_central($usuario['grupos']) /*&& false*/)
                {
                    echo $filtros['nivel_central'];
                }else if(is_nivel_estrategico($usuario['grupos']) /*|| true*/)
                {
                    echo $filtros['estrategico'];
                }else if(is_nivel_tactico($usuario['grupos']) /*|| true*/ )
                {
                    echo $filtros['tactico'];
                }
                ?>
                <div class="row">
                    <input type="submit" value="Buscar" class="btn btn-primary">
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo form_close(); ?>

<div id="area_resultados"></div>

<script type="text/javascript">
    var opciones_filtros = <?php echo json_encode($opciones_filtros); ?>;
</script>
