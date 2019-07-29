$(function(){
    $('.req_nivel').css('display', 'none');
    $('#form_ranking').submit(function(event){
        event.preventDefault();
        if(valida_campos()){
            var destino = site_url + '/ranking/continua';
            data_ajax(destino, '#form_ranking' , '#area_resultados');
        }else{
            alert('Seleccione los campos requeridos');
        }

    });
});

function cmbox_nivel(item){
    var valor = "" + item.value;
    switch (valor) {
        case '1':
            removeOptions(document.getElementById('nivel_atencion'));
            $.each(opciones_filtros.niveles_atencion, function(index, value) {
                var $option = $('<option value="'+index+'">'+value+'</option>');
                $('#nivel_atencion').append($option);
            });
            $('#nivel_atencion').val('');
            removeOptions(document.getElementById('tipo_unidad'));
            $('.req_nivel').css('display', 'block');
            $('#delegacion').val('');
            break;
        case '2':
            removeOptions(document.getElementById('nivel_atencion'));
            $('#nivel_atencion').append($('<option value="3">Tercer nivel</option>'));
            $('#nivel_atencion').val('3');
            $('.req_nivel').css('display', 'block');
            $('#field_niveles_atencion').css('display', 'none');
            $('#field_delegacion').css('display', 'none');
            removeOptions(document.getElementById('tipo_unidad'));
            $.each(opciones_filtros.tipos_unidades['3'], function(index, value) {
                var $option = $('<option value="'+index+'">'+value+'</option>');
                $('#tipo_unidad').append($option);
            });
            $('#delegacion').val('');
            break;
        default:
            console.log('Otra');
            console.log(valor);
            break;
    }
}

function cmbox_nivel_atencion(item){
    var valor = item.value;
    console.log(opciones_filtros.tipos_unidades[valor]);
    removeOptions(document.getElementById('tipo_unidad'));
    $.each(opciones_filtros.tipos_unidades[valor], function(index, value) {
        var $option = $('<option value="'+index+'">'+value+'</option>');
        $('#tipo_unidad').append($option);
    });
}

function chart(id_chart, tabla, titulo, ytext, color) {
    Highcharts.chart(id_chart, {
        data: {
            table: tabla
        },
        chart: {
            type: 'column'
        },
        colors: color,
        title: {
            text: titulo
        },
        legend: {
            enabled: false
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: ytext
            },
            visible: false
        }, xAxis: {
            labels: {
                rotation: -90
            }
        },
    });
}

function valida_campos(){
    var salida = true;
    var campos = ['umae', 'nivel_atencion', 'programa_educativo', 'tipo_asistente'];
    for(i=0;i<campos.length;i++){
        console.log(document.getElementById(campos[i]));
        if(document.getElementById(campos[i])== null || document.getElementById(campos[i]).value==''){
            salida = false;
        }
    }
    return salida;
}
