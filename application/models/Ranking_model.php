<?php

/**
 * Description of Ranking_model
 *
 * @author chrigarc
 */
class Ranking_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_programas()
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            'id_programa_proyecto', /* 'concat(nombre, $$ [$$, clave, $$]$$) proyecto' */
            'nombre proyecto'
        );
        $this->db->select($select);
        $this->db->where('activo', true);
        $this->db->where("nombre != ''");
        $this->db->order_by(2, 'asc');
        $proyectos = $this->db->get('catalogos.programas_proyecto')->result_array();
        return $proyectos;
    }

    public function get_periodos()
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->distinct();
        $this->db->select('extract(year from fecha_inicio) periodo');
        $this->db->where('activo', true);
        $this->db->order_by('extract(year from fecha_inicio)');
        $periodos = $this->db->get('catalogos.implementaciones')->result_array();
        return $periodos;
    }

    public function get_tipos_reportes()
    {
        return array(1 => 'Aprobados', 2 => 'Por eficiencia terminal');
    }

    public function get_niveles()
    {
        return array(1 => array('1'=>'Primer nivel', '2'=>'Segundo nivel'), 2 => array('3'=>'Tercer nivel'));
    }

    public function get_data($usuario = null, $filtros = [])
    {
        $datos = [];
        if ($usuario != null)
        {
//            $usuario['umae'] = true;
            if ($usuario['umae'])
            {
                $datos = $this->get_info_umae($filtros);
            } else
            {
                $datos = $this->get_info_delegaciones($filtros);
            }
        }
        return $datos;
    }

    private function get_info_umae($filtros)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->start_cache();
        $this->db->join('hechos.hechos_implementaciones_alumnos C ', " C.id_unidad_instituto = B.id_unidad_instituto and B.anio = {$filtros['periodo']}", 'inner');
        $this->db->join('sistema.cargas_informacion CI', 'CI.id_carga_informacion = C.id_carga_informacion', 'inner');
        $this->db->join('catalogos.implementaciones D', 'D.id_implementacion = C.id_implementacion', 'inner');
        $this->db->join('catalogos.cursos E ', ' E.id_curso = D.id_curso', 'inner');
        $this->db->join('catalogos.delegaciones A', 'B.id_delegacion=A.id_delegacion', 'inner');
        $this->db->join('catalogos.regiones reg', 'reg.id_region=A.id_region', 'inner');
        $this->db->join('catalogos.categorias cat', 'cat.id_categoria=C.id_categoria', 'inner');
        $this->db->join('catalogos.grupos_categorias gc', 'gc.id_grupo_categoria=cat.id_grupo_categoria AND gc.activa', 'left');
        $this->db->join('catalogos.subcategorias sub', 'sub.id_subcategoria=gc.id_subcategoria AND sub.activa', 'inner');
        $this->db->join('catalogos.programas_proyecto G ', ' G.id_programa_proyecto = E.id_programa_proyecto', 'inner');
        $this->db->join('catalogos.tipos_unidades t', 'B.id_tipo_unidad = t.id_tipo_unidad', 'inner');
        $this->db->where("(t.grupo_tipo = 'UMAE' OR t.grupo_tipo = 'CUMAE')");
        $this->db->where('CI.activa', true);
        if (isset($filtros['periodo']) && !empty($filtros['periodo']))
        {
            $inicio = $filtros['periodo'] . '/01/01';
            $fin = $filtros['periodo'] . '/12/31';
            $this->db->where('E.anio', $filtros['periodo']);
        }
        if (isset($filtros['programa']) && !empty($filtros['programa']))
        {
            $this->db->where('G.id_programa_proyecto', $filtros['programa']);
        }
        $this->db->order_by(1);
        $this->db->stop_cache();
        $datos = [];

        if (isset($filtros['agrupamiento']) && $filtros['agrupamiento'] == 0)
        {
            $select = array('B.nombre nombre',
                'sum("C".cantidad_alumnos_certificados) aprobados',
                'sum("C".cantidad_alumnos_inscritos) inscritos',
                'sum("C".cantidad_no_accesos) no_acceso');
            $this->db->group_by('B.nombre');
        } else
        {
            $select = array('B.nombre_unidad_principal nombre',
                'sum("C".cantidad_alumnos_certificados) aprobados',
                'sum("C".cantidad_alumnos_inscritos) inscritos',
                'sum("C".cantidad_no_accesos) no_acceso');

            $this->db->group_by('B.nombre_unidad_principal');
        }
        $this->db->select($select);
        $datos = $this->db->get('catalogos.unidades_instituto B')->result_array();
//        pr($this->db->last_query());
        $this->db->reset_query();
        $this->db->flush_cache();
        //pr($datos);
        return $datos;
    }

    private function get_info_delegaciones($filtros)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->start_cache();
        $this->db->join('catalogos.unidades_instituto B', "A.id_delegacion = B.id_delegacion AND B.anio = {$filtros['periodo']}", 'inner');
        $this->db->join('hechos.hechos_implementaciones_alumnos C ', ' C.id_unidad_instituto = B.id_unidad_instituto', 'inner');
        $this->db->join('sistema.cargas_informacion CI', 'CI.id_carga_informacion = C.id_carga_informacion', 'inner');
        $this->db->join('catalogos.implementaciones D', 'D.id_implementacion = C.id_implementacion', 'inner');
        $this->db->join('catalogos.cursos E ', ' E.id_curso = D.id_curso', 'inner');
        $this->db->join('catalogos.regiones reg', 'reg.id_region=A.id_region', 'inner');
        $this->db->join('catalogos.programas_proyecto G ', ' G.id_programa_proyecto = E.id_programa_proyecto', 'inner');
        $this->db->join('catalogos.categorias cat', 'cat.id_categoria=C.id_categoria', 'left');
        $this->db->join('catalogos.grupos_categorias gc', 'gc.id_grupo_categoria=cat.id_grupo_categoria AND gc.activa', 'left');
        $this->db->join('catalogos.subcategorias sub', 'sub.id_subcategoria=gc.id_subcategoria AND sub.activa', 'inner');
        $this->db->join('catalogos.tipos_unidades t', 'B.id_tipo_unidad = t.id_tipo_unidad', 'inner');
        $this->db->where("(t.grupo_tipo != 'UMAE' and t.grupo_tipo != 'CUMAE')");
        $this->db->where('CI.activa', true);
        if (isset($filtros['periodo']) && !empty($filtros['periodo']))
        {
            $inicio = $filtros['periodo'] . '/01/01';
            $fin = $filtros['periodo'] . '/12/31';
            $this->db->where('E.anio', $filtros['periodo']);
        }
        if (isset($filtros['programa']) && !empty($filtros['programa']))
        {
            $this->db->where('G.id_programa_proyecto', $filtros['programa']);
        }
        $this->db->order_by(1);
        $this->db->stop_cache();
        $datos = [];

        if (isset($filtros['agrupamiento']) && $filtros['agrupamiento'] == 0)
        {
            $select = array('A.nombre  nombre',
                'sum("C".cantidad_alumnos_certificados) aprobados',
                'sum("C".cantidad_alumnos_inscritos) inscritos',
                'sum("C".cantidad_no_accesos) no_acceso');
            $this->db->group_by('A.nombre');
        } else
        {
            $select = array('A.nombre_grupo_delegacion nombre',
                'sum("C".cantidad_alumnos_certificados) aprobados',
                'sum("C".cantidad_alumnos_inscritos) inscritos',
                'sum("C".cantidad_no_accesos) no_acceso');

            $this->db->group_by('A.nombre_grupo_delegacion');
        }
        $this->db->select($select);
//        $this->db->order_by(A.nombre_grupo_delegacion);
        $datos = $this->db->get('catalogos.delegaciones A')->result_array();
//        pr($this->db->last_query());
        $this->db->reset_query();
        $this->db->flush_cache();
        //pr($datos);
        return $datos;
    }

    public function get_cursos($filtros = [])
    {
        $cursos = [];
        $this->db->reset_query();
        $this->db->flush_cache();
        $select = array(
            'clave', 'nombre'
        );
        $this->db->select($select);
        if(isset($filtros['id_programa_proyecto'])){
            $this->db->where('id_programa_proyecto', $filtros['id_programa_proyecto']);
        }
        if(isset($filtros['anio'])){
            $this->db->where('anio', $filtros['anio']);
        }
        $this->db->where('A.activo', true);
        $cursos = $this->db->get('catalogos.cursos A')->result_array();
        $this->db->reset_query();
        $this->db->flush_cache();
        return $cursos;
    }

    public function get_filtros_continua()
    {
        $salida = [];
        $filtros['select'] = array('anio key', 'anio valor');
        $filtros['group_by'] = array(1);
        $salida['anios'] = $this->get_registros('"dec".h_indicadores', $filtros);
        $filtros['select'] = array('grupo_delegacion', 'nombre_grupo_delegacion', 'id_region');
        $filtros['group_by'] = array(1, 2, 3);
        $filtros['order_by'] = array(2);
        $filtros['where_not_in'] = array('clave_delegacional' => array('00', '39', '09'));
        $salida['delegaciones'] = $this->get_registros('catalogos.delegaciones', $filtros);
        $salida['delegacion_region'] =  $salida['delegaciones'];
        $filtros = [];
        $filtros['select'] = array('anio', 'I.id_programa_proyecto', 'nombre');
        $filtros['join'] = array(
            array('table' => 'dec.h_indicadores I', 'condition' =>'I.id_programa_proyecto = P.id_programa_proyecto', 'type' => 'inner')
        );
        $filtros['group_by'] = array(1, 2, 3);
        $filtros['where'] = array('P.id_programa_proyecto !='=> 1);
        $filtros['order_by'] = array(1, 3);
        $salida['programas_educativos'] = $this->get_registros('catalogos.programas_proyecto P', $filtros);
        $filtros = [];
        $filtros['select'] = array('nivel', 'id_tipo_unidad', 'nombre');
        $filtros['order_by'] = array(1, 3);
        $salida['tipos_unidades'] = $this->get_registros('catalogos.tipos_unidades', $filtros);
        $salida['anios'] = dropdown_options($salida['anios'], 'key', 'valor');
        $salida['delegaciones'] = dropdown_options($salida['delegaciones'], 'grupo_delegacion', 'nombre_grupo_delegacion');
        $programas = [];
        foreach ($salida['programas_educativos'] as $row)
        {
            if(!isset($programas[$row['anio']]))
            {
                $programas[$row['anio']] = [];
            }
            $programas[$row['anio']][] = array('id_programa_proyecto' => $row['id_programa_proyecto'], 'nombre' => $row['nombre']);
        }
        $salida['programas_educativos'] = [];
        foreach ($programas as $key => $value)
        {
            $salida['programas_educativos'][$key] = dropdown_options($programas[$key], 'id_programa_proyecto', 'nombre');
        }
        $tipos_unidades = [];
        foreach ($salida['tipos_unidades'] as $row)
        {
            if(!isset($tipos_unidades[$row['nivel']]))
            {
                $tipos_unidades[$row['nivel']] = [];
            }
            $tipos_unidades[$row['nivel']][] = array('id_tipo_unidad' => $row['id_tipo_unidad'], 'nombre' => $row['nombre']);
        }
        $salida['tipos_unidades'] = [];
        foreach ($tipos_unidades as $key => $value)
        {
            $salida['tipos_unidades'][$key] = dropdown_options($tipos_unidades[$key], 'id_tipo_unidad', 'nombre');
        }
        $delegaciones_region = [];
        foreach ($salida['delegacion_region'] as $row)
        {
            if(!isset($delegaciones_region[$row['id_region']]))
            {
                $delegaciones_region[$row['id_region']] = [];
            }
            $delegaciones_region[$row['id_region']][] = array('grupo_delegacion' => $row['grupo_delegacion'], 'nombre_grupo_delegacion' => $row['nombre_grupo_delegacion']);
        }
        $salida['delegacion_region'] = [];
        // pr($delegaciones_region);
        foreach ($delegaciones_region as $key => $value)
        {
            $salida['delegacion_region'][$key] = dropdown_options($delegaciones_region[$key], 'grupo_delegacion', 'nombre_grupo_delegacion');
        }
        return $salida;
    }

    public function get_data_continua(&$params = [])
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        $tipo_asistente = 'sum(denominador) valor, sum(numerador) valor2 '; //numerador son asistencias
        switch ($params['tipo_asistente'])
        {
            // se retiran ya que desean los valores juntos de los asistentes
            // case '2':
            //     $tipo_asistente = 'sum(denominador) valor';
            //     break;
            case '3':
                $tipo_asistente = '(CASE when sum(denominador) = 0 then 0.0 else (sum(numerador)::float/sum(denominador)::float)*100.0 end)  valor';
                break;
            default:
                break;
        }
        $this->db->select($tipo_asistente);
        if($params['umae'] == 1)
        {

            $this->db->where_not_in('uni.grupo_tipo_unidad', array('UMAE', 'CUMAE'));
            if(isset($params['delegacion']) && $params['delegacion'] != '')
            {
                $this->db->select('uni.nombre unidad');
                $this->db->group_by('uni.nombre');
                $this->db->select('DEL.nombre_grupo_delegacion delegacion');
                $this->db->group_by('DEL.nombre_grupo_delegacion');
                $this->db->where('DEL.grupo_delegacion', $params['delegacion']);
            }else
            {
                $this->db->select('DEL.nombre_grupo_delegacion delegacion');
                $this->db->group_by('DEL.nombre_grupo_delegacion');
            }
        }else
        {
            $this->db->select('uni.nombre unidad');
            $this->db->where_in('uni.grupo_tipo_unidad', array('UMAE', 'CUMAE'));
            $this->db->group_by('uni.nombre');
        }

        if(isset($params['tipo_unidad']) && $params['tipo_unidad'] != '')
        {
            $this->db->where('uni.id_tipo_unidad', $params['tipo_unidad']);
        }
        
        if(isset($params['nivel_atencion']) && $params['nivel_atencion'] != '')
        {
            $this->db->where('uni.nivel_atencion', $params['nivel_atencion']);
        }

        if(isset($params['id_region']) && $params['id_region'] != '')
        {
            $this->db->where('DEL.id_region', $params['id_region']);
        }

        $this->db->where('I.anio', $params['anio']);
        $this->db->where('I.id_programa_proyecto', $params['programa_educativo']);

        $this->db->order_by('1 desc');
        $this->db->from('dec.h_indicadores I');
        $this->db->join('catalogos.unidades_instituto uni', "uni.clave_unidad = I.cve_unidad and uni.anio = {$params['anio']}", 'inner');
        $this->db->join('catalogos.delegaciones DEL','DEL.id_delegacion = uni.id_delegacion', 'inner');
        $salida = $this->db->get()->result_array();
        // pr($this->db->last_query());
        $this->db->reset_query();
        return $salida;
    }
}
