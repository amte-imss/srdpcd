<?php
if (!empty($datos['datos']))
{
    ?>
    <table id="table_ranking" class="table">
        <thead class="text-primary">

          <?php
          if(isset($delegacion) && $delegacion == "Todos")
          { ?>
            <th>Delegación</th>
          <?php
          }
          ?>
        <th>Unidad</th>
        <th>Proceso de Atención Médica</th>
        <th>Asistentes Programados</th>
        <th>Asistentes Aprobados</th>
        <th>Procentaje de Asistentes Aprobados</th>
    </thead>
    <tbody>
      <?php
      //pr($datos['datos']);
      foreach ($datos['datos'] as $row)
      { ?>
        <tr>
            <?php
            if(isset($delegacion) && $delegacion == "Todos")
            { ?>
              <td><?php echo $row['delegacion']?></td>
            <?php
            }
            ?>

            <td><?php echo $row['unidad']?></td>
            <td><?php if($row['programa_educativo'] != '' ){echo $row['programa_educativo'];}else{echo 'Sin Programado Educativo';}?></td>
            <td><?php if($row['denominador'] < 0 || $row['denominador'] == ''){echo '0';}else{echo $row['denominador'];}?></td>
            <td><?php if($row['numerador'] == 0 && $row['denominador'] == ''){echo '0';}else{echo $row['numerador'];}?></td>
            <td><?php if($row['porcentaje'] != '' && $row['denominador'] >= 0){echo $row['porcentaje']." %";}else{echo "-";}?></td>
        </tr>
      <?php } ?>
    </tbody>
    </table>
    <?php
}else
{
    ?>
      <center>
        <h2>NO SE ENCONTRARON DATOS</h2>
      </center>
    <?php
}
?>
