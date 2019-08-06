<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo para generar los reportes de la dec
 *
 * @author Cheko
 */
class Dec_model extends CI_Model
{

    const ANIO = 2017;

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->config->load('general');
        $this->load->database();
    }

    /**
     * Función que genera el reporte
     * dependiendo de la peticion
     * @author Cheko
     * @param array $usuario datos del usuario para generar el reporte
     * @param strig $nivel si es por delegacion o por unidad
     * @param array $peticion el arreglo de datos
     * @return array $estado estado de la repuesta al obtener
     * el reporte
     *
     */
    public function reporte($usuario, $nivel ,$peticion)
    {
        //pr($peticion);
        $this->db->flush_cache();
        $this->db->reset_query();
        $estado = array('success' => false, 'message' => 'Peticion incorrecta', 'datos'=>[]);
        if(count($peticion) < 0)
        {
            return $estado;
        }
        else
        {
            switch ($nivel)
            {
              //NP si asitantes reales es 0 y no tiene programa educativo
              //query join left
                case 'delegacion':
                    //echo 'DELEGACION REPORTE';
                    $select = 'PP.nombre programa_educativo, D.clave_delegacional, D.nombre_grupo_delegacion delegacion
                               ,UI.nombre unidad, PP.descripcion, sum(HI.numerador) numerador
                               ,sum(HI.denominador) denominador, round((sum(HI.numerador::numeric) / nullif(sum(HI.denominador::numeric),0))*100) porcentaje
                               from catalogos.unidades_instituto UI';
                    $join= array(
                        array(
                            'table' => 'catalogos.delegaciones D',
                            'condition' => 'D.id_delegacion = UI.id_delegacion',
                            'type' => 'inner'
                        ),
                        array(
                            'table' => 'catalogos.regiones R',
                            'condition' => 'R.id_region = D.id_region',
                            'type' => 'inner'
                        ),
                        array(
                            'table' => 'dec.h_indicadores HI',
                            'condition' => 'HI.cve_unidad = UI.clave_unidad',
                            'type' => 'left'
                        ),
                        array(
                            'table' => 'catalogos.programas_proyecto PP',
                            'condition' => 'PP.id_programa_proyecto = HI.id_programa_proyecto',
                            'type' => 'left'
                        )
                    );
                    $where = array('UI.activa' => 'true', 'HI.anio'=>$peticion['anio'],'UI.anio'=>$peticion['anio'],'UI.nivel_atencion' => $peticion['nivel']);
                    $group_by = array('PP.nombre','D.clave_delegacional','D.nombre_grupo_delegacion','UI.nombre','PP.descripcion');
                    $where_claus = "";
                    $order_by = array(
                      array('field' => 'delegacion', 'direction'=>'asc'),
                      array('field' => 'unidad', 'direction'=>'asc')
                    );
                    $like = [];

                    if($peticion['tipo_periodo'] == 'Trimestral')
                    {
                        $where['HI.trimestre'] = $peticion['periodo'];
                    }

                    if($peticion['tipo_periodo'] == 'Semestral')
                    {
                        if($peticion['periodo'] == "1")
                        {
                              $where_claus = "(HI.trimestre='1' OR HI.trimestre='2')";
                        }
                        if($peticion['periodo'] == "2")
                        {
                              $where_claus = "(HI.trimestre='3' OR HI.trimestre='4')";
                        }

                    }

                    if($peticion['region'] != "Todos")
                    {
                        $where['R.id_region'] =  $peticion['region'];
                    }

                    if($peticion['delegacion'] != "Todos")
                    {
                        if(is_numeric($peticion['delegacion'])){
                            $where['UI.id_delegacion'] = $peticion['delegacion'];
                        }else{
                            $like['UI.grupo_delegacion'] = $peticion['delegacion'];
                        }

                    }

                    if($peticion['tipos_unidades'] != "Todos")
                    {
                        $where['UI.id_tipo_unidad'] = $peticion['tipos_unidades'];
                    }
                    $parametros = array(
                        'select' => $select,
                        'join' => $join,
                        'like' => $like,
                        'where_claus' => $where_claus,
                        'where' => $where,
                        'group_by' => $group_by,
                        'order_by' => $order_by
                    );
                    return $this->obtener_reporte($parametros);
                    break;
                case 'umae':
                    $select = "PP.nombre programa_educativo, D.clave_delegacional, D.nombre delegacion
                               ,UI.nombre unidad, PP.descripcion, sum(HI.numerador) numerador
                               ,sum(HI.denominador) denominador, round((sum(HI.numerador::numeric) / nullif(sum(HI.denominador::numeric),0))*100) porcentaje
                               from catalogos.unidades_instituto UI";
                    $join= array(
                        array(
                            'table' => 'catalogos.delegaciones D',
                            'condition' => 'D.id_delegacion = UI.id_delegacion',
                            'type' => 'inner'
                        ),
                        array(
                            'table' => 'catalogos.regiones R',
                            'condition' => 'R.id_region = D.id_region',
                            'type' => 'inner'
                        ),
                        array(
                            'table' => 'dec.h_indicadores HI',
                            'condition' => 'HI.cve_unidad = UI.clave_unidad',
                            'type' => 'left'
                        ),
                        array(
                            'table' => 'catalogos.programas_proyecto PP',
                            'condition' => 'PP.id_programa_proyecto = HI.id_programa_proyecto',
                            'type' => 'left'
                        )
                    );
                    $where = array('UI.activa' => 'true','UI.nivel_atencion' => 3, 'HI.anio'=> $peticion['anio'], 'UI.anio'=>$peticion['anio']);
                    $group_by = array('UI.nombre','PP.nombre','D.clave_delegacional','D.nombre','PP.descripcion');
                    $order_by = array(
                      array('field' => 'unidad', 'direction'=>'asc')
                    );
                    if($peticion['tipos_unidades'] != "Todos")
                    {
                        $where['id_tipo_unidad'] = $peticion['tipos_unidades'];
                    }

                    if($peticion['region'] != "Todos")
                    {
                        $where['UI.id_region'] = $peticion['region'];
                    }

                    if($peticion['tipo_periodo'] == 'Trimestral')
                    {
                        $where['HI.trimestre'] = $peticion['periodo'];
                    }

                    $where_claus = "";
                    if($peticion['tipo_periodo'] == 'Semestral')
                    {
                        if($peticion['periodo'] == "1")
                        {
                              $where_claus = "(HI.trimestre='1' OR HI.trimestre='2')";
                        }
                        if($peticion['periodo'] == "2")
                        {
                              $where_claus = "(HI.trimestre='3' OR HI.trimestre='4')";
                        }

                    }

                    $parametros = array(
                        'select' => $select,
                        'join' => $join,
                        'where_claus' => $where_claus,
                        'where' => $where,
                        'group_by' => $group_by,
                        'order_by' => $order_by
                    );
                    return $this->obtener_reporte($parametros);
                    break;
                default:
                    return $this->obtener_reporte();
                    break;
            }
        }
    }

    /**
     * Función que obtiene el reporte de unidades totales
     * dependiendo de la peticion
     * @author Cheko
     * @param array $usuario datos del usuario para generar el reporte
     * @param strig $nivel si es por delegacion o por unidad
     * @param array $peticion el arreglo de datos
     * @return array $estado estado de la repuesta al obtener
     * el reporte
     *
     */
    public function reporte_total_unidades($usuario, $nivel ,$peticion)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $estado = array('success' => false, 'message' => 'Peticion incorrecta', 'datos'=>[]);
        if(count($peticion) < 0)
        {
            return $estado;
        }
        else
        {
            switch ($nivel)
            {
                case 'delegacion':
                    $select = "count(UI.clave_unidad) total_unidades from catalogos.unidades_instituto UI";
                    $where = array('UI.activa' => 'true', 'UI.nivel_atencion' => $peticion['nivel'], 'UI.anio'=>$peticion['anio']);
                    $like = [];
                    if($peticion['region'] != "Todos")
                    {
                        $where['UI.id_region'] = $peticion['region'];
                    }

                    if($peticion['delegacion'] != "Todos")
                    {
                        if(is_numeric($peticion['delegacion'])){
                            $where['UI.id_delegacion'] = $peticion['delegacion'];
                        }else{
                            $like['UI.grupo_delegacion'] = $peticion['delegacion'];
                        }
                    }

                    if($peticion['tipos_unidades'] != "Todos")
                    {
                        $where['UI.id_tipo_unidad'] = $peticion['tipos_unidades'];
                    }

                    $parametros = array(
                        'select' => $select,
                        'like' => $like,
                        'where' => $where
                    );
                    return $this->obtener_reporte($parametros);
                    break;
                case 'umae':
                    $select = "count(UI.clave_unidad) total_unidades from catalogos.unidades_instituto UI";
                    $where = array('UI.activa' => 'true','UI.nivel_atencion' => 3, 'UI.anio'=>$peticion['anio']);
                    $like=[];
                    if($peticion['region'] != "Todos")
                    {
                        $where['UI.id_region'] = $peticion['region'];
                    }

                    // if($peticion['delegacion'] != "Todos")
                    // {
                    //     if(is_numeric($peticion['delegacion'])){
                    //         $where['UI.id_delegacion'] = $peticion['delegacion'];
                    //     }else{
                    //         $like['UI.grupo_delegacion'] = $peticion['delegacion'];
                    //     }
                    // }

                    if($peticion['tipos_unidades'] != "Todos")
                    {
                        $where['UI.id_tipo_unidad'] = $peticion['tipos_unidades'];
                    }
                    $parametros = array(
                        'select' => $select,
                        'like' => $like,
                        'where' => $where
                    );

                    return $this->obtener_reporte($parametros);
                    break;
                default:
                    return $this->obtener_reporte();
                    break;
            }
        }
    }

    /**
     * Función que obtiene el reporte de unidades totales
     * dependiendo de la peticion
     * @author Cheko
     * @param array $usuario datos del usuario para generar el reporte
     * @param strig $nivel si es por delegacion o por unidad
     * @param array $peticion el arreglo de datos
     * @return array $estado estado de la repuesta al obtener
     * el reporte
     *
     */
    public function reporte_total_unidades_programa($usuario, $nivel ,$peticion)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $estado = array('success' => false, 'message' => 'Peticion incorrecta', 'datos'=>[]);
        if(count($peticion) < 0)
        {
            return $estado;
        }
        else
        {
            switch ($nivel)
            {
                case 'delegacion':
                    $select = 'count(distinct UI.clave_unidad) total_unidades from catalogos.unidades_instituto UI';
                    $join= array(
                        array(
                            'table' => 'dec.h_indicadores HI',
                            'condition' => 'HI.cve_unidad = UI.clave_unidad',
                            'type' => 'left'
                        )
                    );
                    $where = array('UI.anio'=>$peticion['anio'],'HI.anio'=>$peticion['anio'],'UI.activa' => 'true', 'UI.nivel_atencion' => $peticion['nivel'], 'HI.numerador >' => 0);
                    $like = [];
                    if($peticion['region'] != "Todos")
                    {
                        $where['UI.id_region'] = $peticion['region'];
                    }

                    if($peticion['delegacion'] != "Todos")
                    {
                        if(is_numeric($peticion['delegacion'])){
                            $where['UI.id_delegacion'] = $peticion['delegacion'];
                        }else{
                            $like['UI.grupo_delegacion'] = $peticion['delegacion'];
                        }
                    }

                    if($peticion['tipo_periodo'] == 'Trimestral')
                    {
                        $where['HI.trimestre'] = $peticion['periodo'];
                    }
                    $where_claus = "";
                    if($peticion['tipo_periodo'] == 'Semestral')
                    {
                        if($peticion['periodo'] == "1")
                        {
                              $where_claus = "(HI.trimestre='1' OR HI.trimestre='2')";
                        }
                        if($peticion['periodo'] == "2")
                        {
                              $where_claus = "(HI.trimestre='3' OR HI.trimestre='4')";
                        }

                    }

                    if($peticion['tipos_unidades'] != "Todos")
                    {
                        $where['UI.id_tipo_unidad'] = $peticion['tipos_unidades'];
                    }
                    $parametros = array(
                        'select' => $select,
                        'join' => $join,
                        'where_claus' => $where_claus,
                        'like' => $like,
                        'where' => $where
                    );
                    return $this->obtener_reporte($parametros);
                    break;
                case 'umae':
                    $select = 'count(distinct UI.clave_unidad) total_unidades from catalogos.unidades_instituto UI';
                    $join= array(
                        array(
                            'table' => 'dec.h_indicadores HI',
                            'condition' => 'HI.cve_unidad = UI.clave_unidad',
                            'type' => 'left'
                        )
                    );
                    $where = array('UI.anio'=>$peticion['anio'],'HI.anio'=>$peticion['anio'],'UI.activa' => 'true', 'UI.nivel_atencion' => 3, 'HI.numerador >' => 0);
                    $like = [];
                    if($peticion['region'] != "Todos")
                    {
                        $where['UI.id_region'] = $peticion['region'];
                    }

                    // if($peticion['delegacion'] != "Todos")
                    // {
                    //     if(is_numeric($peticion['delegacion'])){
                    //         $where['UI.id_delegacion'] = $peticion['delegacion'];
                    //     }else{
                    //         $like['UI.grupo_delegacion'] = $peticion['delegacion'];
                    //     }
                    // }

                    if($peticion['tipo_periodo'] == 'Trimestral')
                    {
                        $where['HI.trimestre'] = $peticion['periodo'];
                    }
                    $where_claus = "";
                    if($peticion['tipo_periodo'] == 'Semestral')
                    {
                        if($peticion['periodo'] == "1")
                        {
                              $where_claus = "(HI.trimestre='1' OR HI.trimestre='2')";
                        }
                        if($peticion['periodo'] == "2")
                        {
                              $where_claus = "(HI.trimestre='3' OR HI.trimestre='4')";
                        }

                    }

                    if($peticion['tipos_unidades'] != "Todos")
                    {
                        $where['UI.id_tipo_unidad'] = $peticion['tipos_unidades'];
                    }
                    $parametros = array(
                        'select' => $select,
                        'join' => $join,
                        'where_claus' => $where_claus,
                        'like' => $like,
                        'where' => $where
                    );
                    return $this->obtener_reporte($parametros);
                    break;
                default:
                    return $this->obtener_reporte();
                    break;
            }
        }
    }

    /**
     * Función que obtiene el reporte dependiendo
     * los parametros obtenido
     * @param array params Arreglo de parametros de la query
     * @return array estado  Estado de la peticion
     */
    private function obtener_reporte(&$params = [])
    {
       $estado = array('success' => false, 'message' => 'Peticion incorrecta', 'datos'=>[]);
       if(count($params) < 0)
       {
         return $estado;
       }
       try{
         $this->db->flush_cache();
         $this->db->reset_query();
         if (isset($params['total']))
         {
             $select = 'count(*) total';
         } else if (isset($params['select']))
         {
             $select = $params['select'];
         } else
         {
             $select = '*';
         }
         $this->db->select($select,false);
         if(isset($params['from']))
         {
            $this->db->from($params['from'],false);
         }

         if (isset($params['join']))
         {
             foreach ($params['join'] as $value)
             {
                 $this->db->join($value['table'], $value['condition'], $value['type'], false);
             }
         }
         if (isset($params['where']))
         {
             foreach ($params['where'] as $key => $value)
             {
                 $this->db->where($key, $value, false);
             }
         }

         if(isset($params['where_claus']))
         {
            if($params['where_claus'] != "")
            {
                $this->db->where($params['where_claus'],NULL, false);
            }

         }

         if(isset($params['like']))
         {
             if(count($params['like']) > 0){
                 foreach ($params['like'] as $key => $value)
                 {
                     $this->db->like($key, $value,'none',false);
                 }
             }

         }

         if(isset($params['group_by']))
         {
            $this->db->group_by($params['group_by'], false);
         }

         if(isset($params['having']))
         {
            $this->db->having($params['having'], false);
         }

         if(isset($params['order_by']))
         {
             foreach ($params['order_by'] as $value)
             {
                 $this->db->order_by($value['field'], $value['direction'],false);
             }
            //$this->db->order_by($params['order_by']['field'], $params['order_by']['direction'], false);
         }

         if (isset($params['limit']) && isset($params['offset']) && !isset($params['total']))
         {
             $this->db->limit($params['limit'], $params['offset']);
         } else if (isset($params['limit']) && !isset($params['total']))
         {
             $this->db->limit($params['limit']);
         }
         //pr($this->db->result_id->queryString);
         $query = $this->db->get();
         //pr($this->db->last_query());
         $salida = $query->result_array();
         $query->free_result();
         $this->db->flush_cache();
         $this->db->reset_query();
         $estado['success'] = true;
         $estado['message'] = "Se obtuvo el reporte con exito";
         $estado['datos'] = $salida;

       }
       catch(Exception $ex)
       {
           $estado['success'] = false;
           $estado['message'] = "Error de base de datos";
           $estado['datos'] = $ex;
       }
       return $estado;

    }
}
