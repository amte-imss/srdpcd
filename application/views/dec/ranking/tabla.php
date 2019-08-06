<?php
if (!empty($datos['datos']))
{
    ?>
    <table id="table_ranking" class="table">
      <thead class="text-primary">
        <?php if($asistentes == 'Asistentes programados vs Asistentes aprobados')
        {
        ?>
          <th>Proceso de Atención Médica</th>
          <th>Asistentes Programados</th>
          <th>Asistentes Aprobados</th>
        <?php
      }else{
        ?>
          <th>Proceso de Atención Médica</th>
          <th><?php echo $asistentes; ?></th>
        <?php
      }
        ?>

      </thead>
    <tbody>
      <?php
      foreach ($datos['datos'] as $row)
      {
        ?>
        <tr>

            <td><?php echo $row['nombre'] ?></td>
            <?php
              if(isset($row['programados']))
              { ?>
                  <td><?php echo $row['programados'];?></td>
              <?php
              }
              if(isset($row['reales']))
              { ?>
                  <td><?php echo $row['reales'];?></td>
              <?php
              }
              if(isset($row['porcentaje']))
              { ?>
                  <td><?php echo $row['porcentaje'];?></td>
              <?php
              }
            ?>

        </tr>
      <?php

      } ?>
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
