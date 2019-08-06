<?php //pr($params); ?>
<div class="row">
    <div class="col-md-1"></div>

    <div class="col-md-10">
        <div id="grafica" class="">

        </div>

    </div>
    <div class="col-md-1"></div>
</div>

<div class="row">
    <div class="col-md-1"></div>

    <div class="col-md-10">
        <?php echo is_nivel_central($usuario['grupos']) ? '' : '<center style="font-weight: bold;">* Ranking Intrarregional (Delegaciones que pertenecen a la región)</center>'; ?>
        <table class="table">
            <tbody>
                <td>Analizado por: <span id="span_nivel"></span></td>
                <td class="table_delegacion">Delegación: <span id="span_delegacion"></span></td>
                <td>Año: <span id="span_anio"></span></td>
                <td>Tipo unidad: <span id="span_tipo_unidad"></span></td>
                <td>Proceso de Atención Médica: <span id="span_programa"></span></td>
            </tbody>
        </table>

    </div>
    <div class="col-md-1"></div>
</div>


<div class="row">
    <div class="col-md-1"></div>

    <div class="col-md-10">

        <table id="table_ranking" class="table">
            <thead class="text-primary">
                <th>Ranking</th>
                <th class="table_unidad">Unidad</th>
                <th class="table_delegacion">Delegación</th>
                <th id="th_tipo_asistente"></th>
                <th id="th_tipo_asistente2">Asistentes Aprobados</th>
            </thead>
            <tbody>
                <?php
                $i  = 1;
                foreach ($result as $row)
                {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td class="table_unidad"><?php echo isset($row['unidad'])?$row['unidad']:''; ?></td>
                        <td class="td_delegacion table_delegacion"><?php echo isset($row['delegacion'])?$row['delegacion']:''; ?></td>
                        <td><?php echo round($row['valor']); ?></td>
                        <?php if(isset($row['valor2']))
                        {
                            echo "<td>{$row['valor2']}</td>";
                        }
                        ?>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>

        <table id="datos_table_ranking" class="table" style="display:none;">
            <thead class="text-primary">
                <?php
                if($params['umae'] == '1' && $params['delegacion'] != ''){
                    ?>
                    <th >Unidad</th>
                    <?php
                }else if($params['umae'] == '1')
                {
                    ?>
                    <th >Delegación</th>
                    <?php
                }else{
                    ?>
                    <th >Unidad</th>
                    <?php
                }
                ?>
                <?php if($params['tipo_asistente'] == 1)
                {
                    echo "<th>Asistentes Programados</th>";
                    echo "<th>Asistentes Aprobados</th>";
                }else if($params['tipo_asistente'] == 3)
                {
                    echo "<th>Porcentaje de asistencia</th>";
                }
                ?>
            </thead>
            <tbody>
                <?php
                $i  = 1;
                foreach ($result as $row)
                {
                    ?>
                    <tr>
                        <?php
                        if(($params['umae'] == '1' && $params['delegacion'] != '') || $params['umae'] == '2'){
                            ?>
                            <td><?php echo isset($row['unidad'])?$row['unidad']:''; ?></td>
                            <?php
                        }else if($params['umae'] == '1')
                        {
                            ?>
                            <td><?php echo isset($row['delegacion'])?$row['delegacion']:''; ?></td>
                            <?php
                        }
                        ?>
                        <td><?php echo round($row['valor']); ?></td>
                        <?php if(isset($row['valor2']))
                        {
                            echo "<td>{$row['valor2']}</td>";
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>

    </div>
    <div class="col-md-1"></div>
</div>

<script type="text/javascript">
var opciones_seleccionadas = <?php echo json_encode($params); ?>;
$(function(){
  $('#th_tipo_asistente').html('Asistentes Programados');
})
</script>
<?php echo js('ranking/continua/resultados.js'); ?>
