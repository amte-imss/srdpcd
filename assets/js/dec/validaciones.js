
//Funcion que detecta un submit para validar los campos de los formularios
$(function () {
    $('#form_validaciones_dec').submit(function (event) {
        var form_campos = $(this).serializeArray();
        var campos = [];
        //console.log("Campos: ", form_campos);
        form_campos.forEach(function(elemento){
          //console.log("Name: ", elemento.name);
          if(elemento.name == 'tipo_periodo')
          {
            if(elemento.value == 'Anual'){

            }else{
                campos.push(elemento.name);
            }
          }else{
              campos.push(elemento.name);
          }

        })
        //console.log(campos);
        if(form_campos[0].name == 'nivel_analisis'){
          if(form_campos[0].value == 'umae'){
            campos = ['tipos_unidades'];
          }
        }
        if (!valida_filtros(campos)) {
            event.preventDefault();
            alert('Seleccione los campos requeridos');
        }
    });
});

//Funcion que valida los filtros de cada formulario
function valida_filtros(fields) {
      var campos = fields;
      var valido = true;
      for (i = 0; i < campos.length; i++) {
          if (document.getElementById(campos[i]) != null) {
              var value = document.getElementById(campos[i]).value;
              if (value == null || value == "") {
                  valido = false;
                  //console.log('elemento no encontrado: ' + campos[i]);
              }
          } else {
              //console.log('elemento no encontrado: ' + campos[i]);
              valido = false;
          }
      }
      return valido;
}
