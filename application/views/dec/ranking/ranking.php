<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div id="filtros_capa_header" class="card-header" data-background-color="green" data-toggle="collapse" data-target="#filtros_capa">
                <a href="#" data-toggle="collapse" data-target="#filtros_capa">Filtros<i class="fa fa-arrow-right pull-right" aria-hidden="true"></i><!-- <div class="material-icons pull-right">keyword_arrow_right</div> -->
                </a>
            </div>
            <?php
            echo js('ranking/index.js');
            echo js('dec/dec.js');
            echo js('dec/validaciones.js');
            echo form_open('dec/ranking', array('id' => 'form_validaciones_dec'));
            ?>
            <div id="filtros_capa" class="card-content">
                <?php
                //pr($usuario);
                if (isset($usuario['central']) && isset($usuario['estrategico']) && isset($usuario['tactico'])){
                    if($usuario['central'])
                    { ?>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon">*Analizar por:</span>
                                    <?php
                                    echo $this->form_complete->create_element(
                                            array('id' => 'nivel_analisis',
                                                'type' => 'dropdown',
                                                'first' => array('' => 'Seleccione...'),
                                                'options' => array('delegacional' => 'Delegacional', 'umae' => 'UMAE'),
                                                'attributes' => array(
                                                    'class' => 'form-control  form-control input-sm',
                                                    'data-toggle' => 'tooltip',
                                                    'data-placement' => 'top',
                                                    'onchange' => 'esconder_filtros(this)',
                                                    'title' => 'UMAE')
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div id="reg" class="col-md-3">
                                <div class="input-group input-group-sm">
                                    <span id="textReg" class="input-group-addon">*Región:</span>
                                    <?php
                                      echo $this->form_complete->create_element(
                                              array('id' => 'region',
                                                  'type' => 'dropdown',
                                                  'first' => array('' => 'Seleccione...'),
                                                  'options' => $regiones,
                                                  'attributes' => array(
                                                      'class' => 'form-control  form-control input-sm',
                                                      'data-toggle' => 'tooltip',
                                                      'data-placement' => 'top',
                                                      'onchange' => 'mostrar_delegaciones(this)',
                                                      'title' => 'Regiones')
                                              )
                                      );
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4" id="del">
                                <div class="input-group input-group-sm">
                                    <span id="textDel" class="input-group-addon">*Delegaciones:</span>
                                    <?php
                                    echo $this->form_complete->create_element(
                                            array('id' => 'delegacion',
                                                'type' => 'dropdown',
                                                'first' => array('' => 'Seleccione...'),
                                                'attributes' => array(
                                                    'class' => 'form-control  form-control input-sm',
                                                    'data-toggle' => 'tooltip',
                                                    'data-placement' => 'top',
                                                    'title' => 'Delegación',
                                                )
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div id="nivel_aten" class="col-md-4">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon">*Nivel de atención:</span>
                                    <?php
                                    echo $this->form_complete->create_element(
                                            array('id' => 'nivel',
                                                'type' => 'dropdown',
                                                'first' => array('' => 'Seleccione...'),
                                                'options' => array(1=>'Primer nivel', 2 =>'Segundo nivel'),
                                                'attributes' => array(
                                                    'class' => 'form-control  form-control input-sm',
                                                    'data-toggle' => 'tooltip',
                                                    'data-placement' => 'top',
                                                    'onchange' => 'mostrar_tipo_unidades(this)',
                                                    'title' => 'Regiones')
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4" id="tu">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon">*Tipo de unidad:</span>
                                    <?php
                                    echo $this->form_complete->create_element(
                                            array('id' => 'tipos_unidades',
                                                'type' => 'dropdown',
                                                'first' => array('' => 'Seleccione...'),
                                                'attributes' => array(
                                                    'class' => 'form-control  form-control input-sm',
                                                    'data-toggle' => 'tooltip',
                                                    'data-placement' => 'top',
                                                    'title' => 'tipos_unidades')
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            <!-- <div class="col-md-4" id="asis">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon">*Tipo de asistentes:</span>
                                    <?php
                                    // echo $this->form_complete->create_element(
                                    //         array('id' => 'asistentes',
                                    //             'type' => 'dropdown',
                                    //             'first' => array('' => 'Seleccione...'),
                                    //             'options' => array('realesvsprogramados' => 'Programados vs Reales', 'porcentaje'=>'Porcentaje de aprobados'),
                                    //             //'options' => array('programados' => 'Programados', 'reales' => 'Reales'),
                                    //             'attributes' => array(
                                    //                 'class' => 'form-control  form-control input-sm',
                                    //                 'data-toggle' => 'tooltip',
                                    //                 'data-placement' => 'top',
                                    //                 'title' => 'Delegación',
                                    //             )
                                    //         )
                                    // );
                                    ?>
                                </div>
                            </div> -->


                        <?php
                    }
                    else
                    {
                      if($usuario['estrategico'])
                      { ?>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon">*Analizar por:</span>
                                    <?php
                                    echo $this->form_complete->create_element(
                                            array('id' => 'nivel_analisis',
                                                'type' => 'dropdown',
                                                'first' => array('' => 'Seleccione...'),
                                                'options' => array('delegacional' => 'Delegacional', 'umae' => 'UMAE'),
                                                'attributes' => array(
                                                    'class' => 'form-control  form-control input-sm',
                                                    'data-toggle' => 'tooltip',
                                                    'data-placement' => 'top',
                                                    'onchange' => 'esconder_filtros(this)',
                                                    'title' => 'UMAE')
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4" id="del">
                                <div class="input-group input-group-sm">
                                    <span id="textDel" class="input-group-addon">*Delegaciones:</span>
                                    <?php
                                    echo $this->form_complete->create_element(
                                            array('id' => 'delegacion',
                                                'type' => 'dropdown',
                                                'first' => array('' => 'Seleccione...'),
                                                'options' => $delegaciones,
                                                'attributes' => array(
                                                    'class' => 'form-control  form-control input-sm',
                                                    'data-toggle' => 'tooltip',
                                                    'data-placement' => 'top',
                                                    'title' => 'Delegación',
                                                )
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon">*Nivel de atención:</span>
                                    <?php
                                    echo $this->form_complete->create_element(
                                            array('id' => 'nivel',
                                                'type' => 'dropdown',
                                                'first' => array('' => 'Seleccione...'),
                                                'options' => array(1=>'Primer nivel', 2 =>'Segundo nivel'),
                                                'attributes' => array(
                                                    'class' => 'form-control  form-control input-sm',
                                                    'data-toggle' => 'tooltip',
                                                    'data-placement' => 'top',
                                                    'onchange' => 'mostrar_tipo_unidades(this)',
                                                    'title' => 'Regiones')
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4" id="tu">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon">*Tipo de unidad:</span>
                                    <?php
                                    echo $this->form_complete->create_element(
                                            array('id' => 'tipos_unidades',
                                                'type' => 'dropdown',
                                                'first' => array('' => 'Seleccione...'),
                                                'attributes' => array(
                                                    'class' => 'form-control  form-control input-sm',
                                                    'data-toggle' => 'tooltip',
                                                    'data-placement' => 'top',
                                                    'title' => 'tipos_unidades')
                                            )
                                    );
                                    ?>
                                </div>
                            </div>
                            <!-- <div class="col-md-4" id="asis">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon">*Tipo de asistentes:</span>
                                    <?php
                                    // echo $this->form_complete->create_element(
                                    //         array('id' => 'asistentes',
                                    //             'type' => 'dropdown',
                                    //             'first' => array('' => 'Seleccione...'),
                                    //             'options' => array('realesvsprogramados' => 'Programados vs Reales', 'porcentaje'=>'Porcentaje de aprobados'),
                                    //             //'options' => array('programados' => 'Programados', 'reales' => 'Reales'),
                                    //             'attributes' => array(
                                    //                 'class' => 'form-control  form-control input-sm',
                                    //                 'data-toggle' => 'tooltip',
                                    //                 'data-placement' => 'top',
                                    //                 'title' => 'Delegación',
                                    //             )
                                    //         )
                                    // );
                                    ?>
                                </div>
                            </div> -->

                        <?php
                      }
                      else
                      {
                        if($usuario['tactico'])
                        { ?>
                              <div class="col-md-4">
                                  <div class="input-group input-group-sm">
                                      <span class="input-group-addon">*Nivel de atención:</span>
                                      <?php
                                      echo $this->form_complete->create_element(
                                              array('id' => 'nivel',
                                                  'type' => 'dropdown',
                                                  'first' => array('' => 'Seleccione...'),
                                                  'options' => array(1=>'Primer nivel', 2 =>'Segundo nivel'),
                                                  'attributes' => array(
                                                      'class' => 'form-control  form-control input-sm',
                                                      'data-toggle' => 'tooltip',
                                                      'data-placement' => 'top',
                                                      'onchange' => 'mostrar_tipo_unidades(this)',
                                                      'title' => 'Regiones')
                                              )
                                      );
                                      ?>
                                  </div>
                              </div>
                              <div class="col-md-4" id="tu">
                                  <div class="input-group input-group-sm">
                                      <span class="input-group-addon">*Tipo de unidad:</span>
                                      <?php
                                      echo $this->form_complete->create_element(
                                              array('id' => 'tipos_unidades',
                                                  'type' => 'dropdown',
                                                  'first' => array('' => 'Seleccione...'),
                                                  'attributes' => array(
                                                      'class' => 'form-control  form-control input-sm',
                                                      'data-toggle' => 'tooltip',
                                                      'data-placement' => 'top',
                                                      'title' => 'tipos_unidades')
                                              )
                                      );
                                      ?>
                                  </div>
                              </div>
                            </div>
                          <?php
                        }
                      }
                    }
                    ?>
                    <br>
                    <br>
                    <div class="row">
                        <input style="float: right;margin-right: 50px;" type="submit" value="Buscar" class="btn btn-primary">
                    </div>
                </div>
                      <?php
                    }
                    ?>
        </div>
    </div>
</div>

<?php echo form_close(); ?>
<div class="row card">
    <?php
    if (isset($grafica))
    {
        echo $grafica;
    }
    ?>
    <div id="area_table">
        <?php
        if (isset($tabla))
        {
            echo $tabla;
        }
        ?>
    </div>
</div>
<div id="alert-ranking" class="alert alert-warning alert-comparativa" style="display: none">
    <span>
        No existen resultados para esa busqueda, intente con otros filtros por favor.
    </span>
</div>
<script>
$(function(){
  var filtros = <?php if(isset($filtros)){echo json_encode($filtros);}else{echo "'no'";}?>;
  var usuario = <?php if(isset($usuario)){echo json_encode($usuario);}else{echo "'no'";}?>;
  if(filtros != "no"){
    var delegacion_id = filtros.delegacion;
    var nivel_analisis = filtros.nivel;
    var tipo_unidad = filtros.tipos_unidades;
  }
  if(usuario.tactico){
    $.ajax({
        method: "GET",
        url: site_url + "/dec/tipos_unidades/"+filtros.nivel,
    }).done(function( tipos ) {
        //console.log("Respuesta de Tipos de unidades: ", tipos);
        if(tipos.success)
        {
            if(tipos.datos.length > 0)
            {
                tipos.datos.forEach(function(tipoU) {
                    $('#tipos_unidades').append($('<option>', { value: tipoU.id_tipo_unidad, text: tipoU.nombre}));
                });
                $('#tipos_unidades').val(tipo_unidad);
            }
            else
            {
            }
        }
        else
        {
        }

    });
  }
  if($('#nivel_analisis')[0].value != ""){
    if($('#nivel_analisis')[0].value == 'umae'){
      $.ajax({
          method: "GET",
          url: site_url + "/dec/tipos_unidades/"+3,
      }).done(function( tipos ) {
          //console.log("Respuesta de Tipos de unidades: ", tipos);
          if(tipos.success)
          {
              if(tipos.datos.length > 0)
              {
                  tipos.datos.forEach(function(tipoU) {
                      $('#tipos_unidades').append($('<option>', { value: tipoU.id_tipo_unidad, text: tipoU.nombre}));
                  });
                  $('#tipos_unidades').val(tipo_unidad);
              }
              else
              {
              }
          }
          else
          {
          }

      });
    }else{
      $.ajax({
          method: "GET",
          url: site_url + "/dec/tipos_unidades/"+nivel_analisis,
      }).done(function( tipos ) {
          console.log("DENUEVO");
          console.log("Respuesta de Tipos de unidades: ", tipos);
          if(tipos.success)
          {
              if(tipos.datos.length > 0)
              {
                  tipos.datos.forEach(function(tipoU) {
                      $('#tipos_unidades').append($('<option>', { value: tipoU.id_tipo_unidad, text: tipoU.nombre}));
                  });
                  $('#tipos_unidades').val(tipo_unidad);
              }
              else
              {
              }
          }
          else
          {
          }

      });
    }
  }
  if(usuario.central){
    if($('#region')[0].value != "" && $('#delegacion')[0].value == "")
    {
        var region = $('#region')[0].value;
        $.ajax({
            method: "GET",
            url: site_url + "/dec/obtener_delegaciones/"+region,
        }).done(function( delegacion ) {
            //console.log("Respuesta de delegaciones: ", delegacion);
            if(delegacion.success)
            {
                if(delegacion.datos.length > 0)
                {
                    delegacion.datos.forEach(function(itemDelegacion) {
                        $('#delegacion').append($('<option>', { value: itemDelegacion.id_delegacion, text: itemDelegacion.delegacion}));
                    });
                    $('#delegacion').val(delegacion_id);
                }
                else
                {
                  //console.log(delegacion)
                }
            }
            else
            {
              //console.log(delegacion)
            }
        });
    }
    if($('#nivel_analisis')[0].value == 'umae'){

        $('#delegacion').hide()
        $('#region').hide()
        $('#textReg').hide()
        $('#textDel').hide()
        $('#nivel_aten').hide()
        $( "#del" ).removeClass( "col-md-4" )
        $( "#reg" ).removeClass( "col-md-3" )
    }
  }else{
    //console.log("Estrategico");
    if($('#nivel_analisis')[0].value == 'umae'){
      $('#del').hide()
      $('#nivel_aten').hide()
      $( "#del" ).removeClass( "col-md-4" )
    }
  }
})
</script>
