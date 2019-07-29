$(function(){
    $('#span_nivel').html(opciones_filtros.nivel[opciones_seleccionadas.umae]);
    $('#span_delegacion').html(opciones_filtros.delegaciones[opciones_seleccionadas.delegacion]);
    // $('.td_delegacion').html(opciones_filtros.delegaciones[opciones_seleccionadas.delegacion]);
    $('#span_anio').html(opciones_seleccionadas.anio);
    if(opciones_seleccionadas.tipo_unidad == ''){
      $('#span_tipo_unidad').html("Todos");
    }else{
      $('#span_tipo_unidad').html(opciones_filtros.tipos_unidades[opciones_seleccionadas.nivel_atencion][opciones_seleccionadas.tipo_unidad]);
    }
    $('#span_programa').html(opciones_filtros.programas_educativos[opciones_seleccionadas.anio][opciones_seleccionadas.programa_educativo]);
    $('#th_tipo_asistente2').html("Ranking Intrarregional");
    if(opciones_seleccionadas.umae == '1' &&opciones_seleccionadas.delegacion == '')
    {
        $('.table_unidad').css('display', 'none');
    }
    if(opciones_seleccionadas.umae == '2')
    {
        $('.table_delegacion').css('display', 'none');
    }

    var color_opcion =  opciones_seleccionadas.tipo_asistente;
    var color = '';
    switch (color_opcion) {
        case '1': case '2':
        color = ["#0095bc", "#98c56e"];
        break;
        case '3':
        color = ["#f3b510"];
        break;
        default:

    }

    chart('grafica', 'datos_table_ranking', opciones_filtros.tipo_asistente[opciones_seleccionadas.tipo_asistente], opciones_filtros.tipo_asistente[opciones_seleccionadas.tipo_asistente], color);
});
