<p>Estrategico unidad</p>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="nivel_atencion">* Nivel de atención</label>
            <?php
            echo $this->form_complete->create_element(
                array('id' => 'nivel_atencion',
                'type' => 'dropdown',
                'first' => array('' => 'Seleccione...'),
                //'options' => array(0 => 'Delegacional', 1 => 'UMAE'),
                'attributes' => array(
                    'class' => 'form-control',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'title' => 'Nivel de atención')
                )
            );
            ?>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="tipo_unidad">* Tipo de unidad</label>
            <?php
            echo $this->form_complete->create_element(
                array('id' => 'tipo_unidad',
                'type' => 'dropdown',
                'first' => array('' => 'Seleccione...'),
                //'options' => array(0 => 'Delegacional', 1 => 'UMAE'),
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

    <div class="col-md-4">
        <div class="form-group">
            <label for="programa_educativo">* Proceso de atención médica</label>
            <?php
            echo $this->form_complete->create_element(
                array('id' => 'programa_educativo',
                'type' => 'dropdown',
                'first' => array('' => 'Seleccione...'),
                //'options' => array(0 => 'Delegacional', 1 => 'UMAE'),
                'attributes' => array(
                    'class' => 'form-control',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'title' => 'Programa educativo')
                )
            );
            ?>

        </div>
    </div>


</div>
<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <label for="anio">* Año</label>
            <?php
            echo $this->form_complete->create_element(
                array('id' => 'anio',
                'type' => 'dropdown',
                'first' => array('' => 'Seleccione...'),
                //'options' => array(0 => 'Delegacional', 1 => 'UMAE'),
                'attributes' => array(
                    'class' => 'form-control',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'title' => 'Año')
                )
            );
            ?>

        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="tipo_asistente">* Tipo de asistentes</label>
            <?php
            echo $this->form_complete->create_element(
                array('id' => 'tipo_asistente',
                'type' => 'dropdown',
                'first' => array('' => 'Seleccione...'),
                //'options' => array(0 => 'Delegacional', 1 => 'UMAE'),
                'attributes' => array(
                    'class' => 'form-control',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'title' => 'Tipo de asistentes')
                )
            );
            ?>
        </div>
    </div>
</div>
