// Función que esconde algunos filtros dependiendo el nivel
// si es UMAE y Delegacional
function esconder_filtros(nivel){
    if(nivel.value == 'umae'){
        //sconsole.log("UMAE");
        $('#delegacion').hide()
        $('#region').hide()
        $('#textReg').hide()
        $('#textDel').hide()
        $('#nivel_aten').hide()
        $( "#del" ).removeClass( "col-md-4" )
        $( "#reg" ).removeClass( "col-md-3" )
        mostrar_tipo_unidades({value:3})
    }else{
        mostrar_tipo_unidades({value:$('#nivel')[0].value})
        $('#tipos_unidades').html('');
        $('#del').show()
        $('#delegacion').show()
        $('#region').show()
        $('#textReg').show()
        $('#textDel').show()
        $('#nivel_aten').show()
        $( "#del" ).addClass( "col-md-4" )
        $( "#reg" ).addClass( "col-md-3" )
    }
}

//Función que muestra los tipos de unidades dependiendo de nivel
function mostrar_tipo_unidades(nivel)
{
    //console.log(nivel);
    var id = nivel.value;
    $('#tipos_unidades').find('option').remove().end();
    $.ajax({
        method: "GET",
        url: site_url + "/dec/tipos_unidades/"+id,
    }).done(function( tipos ) {
        //console.log("Respuesta de Tipos de unidades: ", tipos);
        if(tipos.success)
        {
            $('#tipos_unidades').append($('<option>', { value: "", text: "Seleccione..."}));
            if(tipos.datos.length > 0)
            {
                tipos.datos.forEach(function(tipoU) {
                    $('#tipos_unidades').append($('<option>', { value: tipoU.id_tipo_unidad, text: tipoU.nombre}));
                });
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

//Función que muestra las delegaciones dependiendo de la region
function mostrar_delegaciones(region)
{
    var region = region.value;
    $('#delegacion').find('option').remove().end();
    $.ajax({
        method: "GET",
        url: site_url + "/dec/obtener_delegaciones/"+region,
    }).done(function( delegacion ) {
        //console.log("Respuesta de delegaciones: ", delegacion);
        if(delegacion.success)
        {
            $('#delegacion').append($('<option>', { value: "", text: "Seleccione..."}));
            if(delegacion.datos.length > 0)
            {
                delegacion.datos.forEach(function(itemDelegacion) {
                    $('#delegacion').append($('<option>', { value: itemDelegacion.id_delegacion, text: itemDelegacion.delegacion}));
                });
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

//Función que muestra los periodos dependiendo el tipo de periodo
function mostrar_periodos(tipo_periodo)
{
  var anios = [2016,2017,2018];
  $('#periodo').find('option').remove().end();
  switch (tipo_periodo.value) {
    case "Trimestral":
      //console.log("Trimestral");
      $('#secPeriodo').show();
      $('#periodo').append($('<option>', { value: "", text: "Seleccione..."}));
      $('#periodo').append($('<option>', { value: 1, text: "Enero-Marzo"}));
      $('#periodo').append($('<option>', { value: 2, text: "Abril-Junio"}));
      $('#periodo').append($('<option>', { value: 3, text: "Julio-Septiembre"}));
      $('#periodo').append($('<option>', { value: 4, text: "Octubre-Diciembre"}));
      break;
    case "Semestral":
      $('#secPeriodo').show();
      $('#periodo').append($('<option>', { value: "", text: "Seleccione..."}));
      $('#periodo').append($('<option>', { value: 1, text: "Enero-Junio"}));
      $('#periodo').append($('<option>', { value: 2, text: "Julio-Diciembre"}));
      break;
    case "Anual":
      //console.log("Anual");
      $('#secPeriodo').hide();
      break;
    default:
      console.log("Default");
  }

}
