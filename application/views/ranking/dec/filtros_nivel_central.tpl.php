<?php
 // pr($opciones_filtros);

  ?>
<!-- <p>Nivel central</p> -->
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="nivel">* Analizar por</label>
            <?php
            echo $this->form_complete->create_element(
                array('id' => 'umae',
                'type' => 'dropdown',
                'first' => array('' => 'Seleccione...'),
                'options' => $opciones_filtros['nivel'],
                'attributes' => array(
                    'class' => 'form-control',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    // 'required' => true,
                    'onchange' => 'cmbox_nivel(this)',
                    'title' => 'UMAE')
                )
            );
            ?>

        </div>
    </div>
</div>
<div class="row">

    <div class="col-md-4" id="field_anios" style="display:none;">
        <div class="form-group">
            <label for="anio">* Año</label>
            <?php
            echo $this->form_complete->create_element(
                array('id' => 'anio',
                'type' => 'dropdown',
                // 'first' => array('' => 'Seleccione...'),
                'options' => $opciones_filtros['anios'],
                'attributes' => array(
                    'class' => 'form-control',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    // 'required' => true,
                    'title' => 'Año')
                )
            );
            ?>

        </div>
    </div>

    <div class="col-md-4 req_nivel" id="field_delegacion">
        <div class="form-group">
            <label for="delegacion">&nbsp;&nbsp;Delegación</label>
            <?php
            echo $this->form_complete->create_element(
                array('id' => 'delegacion',
                'type' => 'dropdown',
                'first' => array('' => 'Todos'),
                'options' => $opciones_filtros['delegaciones'],
                'attributes' => array(
                    'class' => 'form-control',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'title' => 'Delegación')
                )
            );
            ?>

        </div>
    </div>

    <div class="col-md-4 req_nivel" id="field_niveles_atencion" >
        <div class="form-group">
            <label for="nivel_atencion">* Nivel de atención</label>
            <?php
            echo $this->form_complete->create_element(
                array('id' => 'nivel_atencion',
                'type' => 'dropdown',
                'first' => array('' => 'Seleccione...'),
                'options' => $opciones_filtros['niveles_atencion'],
                'attributes' => array(
                    'class' => 'form-control',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    // 'required' => true,
                    'onchange' => 'cmbox_nivel_atencion(this)',
                    'title' => 'Nivel de atención')
                )
            );
            ?>
        </div>
    </div>

</div>
<div class="row">

    <div class="col-md-4 req_nivel" id="field_tipo_unidad" >
        <div class="form-group">
            <label for="tipo_unidad">Tipo de unidad</label>
            <?php
            echo $this->form_complete->create_element(
                array('id' => 'tipo_unidad',
                'type' => 'dropdown',
                'first' => array('' => 'Todos'),
                'options' => [],
                'attributes' => array(
                    'class' => 'form-control',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'title' => 'Tipo de unidad')
                )
            );
            ?>
        </div>
    </div>

    <div class="col-md-4 req_nivel" id="field_programa_educativo" >
        <div class="form-group">
            <label for="programa_educativo">* Proceso de atención médica</label>
            <?php
            echo $this->form_complete->create_element(
                array('id' => 'programa_educativo',
                'type' => 'dropdown',
                'first' => array('' => 'Seleccione...'),
                'options' => $opciones_filtros['programas_educativos']['2017'],
                'attributes' => array(
                    'class' => 'form-control',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    // 'required' => true,
                    'title' => 'Programa educativo')
                )
            );
            ?>

        </div>
    </div>

    <div class="col-md-4" id="field_tipo_asistente" style="display:none;">
        <div class="form-group">
            <label for="tipo_asistente">* Tipo de asistentes</label>
            <?php
            echo $this->form_complete->create_element(
                array('id' => 'tipo_asistente',
                'type' => 'dropdown',
                //'first' => array('' => 'Seleccione...'),
                'options' => $opciones_filtros['tipo_asistente'],
                'attributes' => array(
                    'class' => 'form-control',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    // 'required' => true,
                    'title' => 'Tipo de asistentes')
                )
            );
            ?>
        </div>
    </div>
</div>
