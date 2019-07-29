<?php

/**
 * Obtiene los datos del ranking de la DEC
 *
 * @author Cheko
 */
class Ranking_dec_model extends CI_Model
{
    const ANIO = 2017;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Funcion que obtiene los datos de ranking con base
     * al nivel y los datos solicitados
     * @author Cheko
     * @param $usuario, usuario quien pide el ranking
     * $nivel nivel delegaciona o umae
     * $peticion datos pedidos para el ranking
     *
     */
    public function ranking($usuario, $nivel, $peticion)
    {
        switch ($nivel) {
            case 'umae':
                return $this->ranking_por_umae($usuario,$peticion);
                break;
            case 'delegacional':
                return $this->ranking_por_delegacion($usuario,$peticion);
                break;
            default:
                $estado = array('success' => false, 'message' => 'Peticion incorrecta', 'datos'=>[]);
                return $estado;
                break;
        }
    }

    /**
     * Funcion que obtiene los datos de ranking por delegación
     * @author Cheko
     * @param $usuario, usuario quien pide el ranking
     * $peticion datos pedidos para el ranking
     *
     */
    private function ranking_por_delegacion($usuario, $peticion)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $estado = array('success' => false, 'message' => 'Peticion incorrecta', 'datos'=>[]);
        if(count($peticion) < 0)
        {
            return $estado;
        }
        switch ($peticion['asistentes']) {
          case 'realesvsprogramados':
              $select = 'PP.nombre, HI.id_programa_proyecto, sum(HI.denominador::numeric) programados, sum(HI.numerador::numeric) reales
                        from dec.h_indicadores HI';
              $join= array(
                  array(
                      'table' => 'catalogos.programas_proyecto PP',
                      'condition' => 'PP.id_programa_proyecto = HI.id_programa_proyecto',
                      'type' => 'left'
                  ),
                  array(
                      'table' => 'catalogos.unidades_instituto UI',
                      'condition' => 'UI.clave_unidad = HI.cve_unidad and UI.anio = HI.anio and UI.activa = true',
                      'type' => 'left'
                  )
              );
              $where = array('HI.anio' => Ranking_dec_model::ANIO,'HI.denominador >' => 0);
              $where_claus = null;//"(UI.nivel_atencion='1' OR UI.nivel_atencion='2')";
              $group_by = array('PP.nombre','HI.id_programa_proyecto');
              $order_by = array('field' => 'programados', 'direction'=>'desc');
              $like = [];
              if($peticion['region'] != "Todos")
              {
                  $where['UI.id_region'] =  $peticion['region'];
              }

              if($peticion['nivel'] != "")
              {
                  $where['UI.nivel_atencion'] =  $peticion['nivel'];
              }

              if($peticion['tipos_unidades'] != "Todos")
              {
                  $where['UI.id_tipo_unidad'] = $peticion['tipos_unidades'];
              }

              if($peticion['delegacion'] != "Todos")
              {
                  if(is_numeric($peticion['delegacion'])){
                      $where['UI.id_delegacion'] = $peticion['delegacion'];
                  }else{
                      $like['UI.grupo_delegacion'] = $peticion['delegacion'];
                  }
              }

              if(count($like) > 0){
                  $parametros = array(
                      'select' => $select,
                      'join' => $join,
                      'like' => $like,
                      'where' => $where,
                      'where_claus' => $where_claus,
                      'group_by' => $group_by,
                      'order_by' => $order_by
                  );
              }else{
                $parametros = array(
                    'select' => $select,
                    'join' => $join,
                    'where' => $where,
                    'where_claus' => $where_claus,
                    'group_by' => $group_by,
                    'order_by' => $order_by
                );
              }

              return $this->obtener_reporte($parametros);
              break;
          case 'porcentaje':
            $select = 'PP.nombre, round((sum(HI.numerador::numeric) / nullif(sum(HI.denominador::numeric),0))*100) porcentaje
            from dec.h_indicadores HI';
            $join= array(
                array(
                    'table' => 'catalogos.programas_proyecto PP',
                    'condition' => 'PP.id_programa_proyecto = HI.id_programa_proyecto',
                    'type' => 'left'
                ),
                array(
                    'table' => 'catalogos.unidades_instituto UI',
                    'condition' => 'UI.clave_unidad = HI.cve_unidad and UI.anio = HI.anio and UI.activa = true',
                    'type' => 'left'
                )
            );
            $where = array('HI.anio' => Ranking_dec_model::ANIO,'HI.denominador >' => 0);
            $where_claus = "UI.nivel_atencion='1' OR UI.nivel_atencion='2'";
            $group_by = array('PP.nombre');
            $order_by = array('field' => 'porcentaje', 'direction'=>'desc');
            $like = [];
            if($peticion['region'] != "Todos")
            {
                $where['UI.id_region'] =  $peticion['region'];
            }

            if($peticion['delegacion'] != "Todos")
            {
                  if(is_numeric($peticion['delegacion'])){
                      $where['UI.id_delegacion'] = $peticion['delegacion'];
                  }else{
                      $like['UI.grupo_delegacion'] = $peticion['delegacion'];
                  }
            }

            if(count($like) > 0){
                $parametros = array(
                    'select' => $select,
                    'join' => $join,
                    'like' => $like,
                    'where' => $where,
                    'where_claus' => $where_claus,
                    'group_by' => $group_by,
                    'order_by' => $order_by
                );
            }else{
              $parametros = array(
                  'select' => $select,
                  'join' => $join,
                  'where' => $where,
                  'where_claus' => $where_claus,
                  'group_by' => $group_by,
                  'order_by' => $order_by
              );
            }
            $parametros = array(
                'select' => $select,
                'join' => $join,
                'where' => $where,
                'where_claus' => $where_claus,
                'group_by' => $group_by,
                'order_by' => $order_by
            );
            return $this->obtener_reporte($parametros);
            break;
          default:
            return $this->obtener_reporte();
            break;
        }

        return $estado;
    }

    /**
     * Funcion que obtiene los datos de ranking por umae
     * @author Cheko
     * @param $usuario, usuario quien pide el ranking
     * $peticion datos pedidos para el ranking
     *
     */
    private function ranking_por_umae($usuario, $peticion)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $estado = array('success' => false, 'message' => 'Peticion incorrecta', 'datos'=>[]);
        if(count($peticion) < 0)
        {
            return $estado;
        }
        switch ($peticion['asistentes']) {
          case 'realesvsprogramados':
            $select = 'PP.nombre, HI.id_programa_proyecto, sum(HI.denominador::numeric) programados, sum(HI.numerador::numeric) reales
            from dec.h_indicadores HI';
            $join= array(
                array(
                    'table' => 'catalogos.programas_proyecto PP',
                    'condition' => 'PP.id_programa_proyecto = HI.id_programa_proyecto',
                    'type' => 'left'
                ),
                array(
                    'table' => 'catalogos.unidades_instituto UI',
                    'condition' => 'UI.clave_unidad = HI.cve_unidad and UI.anio = HI.anio and UI.activa = true',
                    'type' => 'left'
                )
            );
            $where = array('HI.anio' => Ranking_dec_model::ANIO,'UI.nivel_atencion' => 3,'HI.denominador >' => 0);
            $group_by = array('PP.nombre','HI.id_programa_proyecto');
            $order_by = array('field' => 'programados', 'direction'=>'desc');

            if($peticion['region'] != 'Todos'){
                $where['UI.id_region'] = $peticion['region'];
            }

            if($peticion['tipos_unidades'] != "Todos")
            {
                $where['UI.id_tipo_unidad'] = $peticion['tipos_unidades'];
            }

            $parametros = array(
                'select' => $select,
                'join' => $join,
                'where' => $where,
                'group_by' => $group_by,
                'order_by' => $order_by
            );
            return $this->obtener_reporte($parametros);
            break;
          case 'porcentaje':
              $select = 'PP.nombre, round((sum(HI.numerador::numeric) / nullif(sum(HI.denominador::numeric),0))*100) porcentaje
              from dec.h_indicadores HI';
              $join= array(
                  array(
                      'table' => 'catalogos.programas_proyecto PP',
                      'condition' => 'PP.id_programa_proyecto = HI.id_programa_proyecto',
                      'type' => 'left'
                  ),
                  array(
                      'table' => 'catalogos.unidades_instituto UI',
                      'condition' => 'UI.clave_unidad = HI.cve_unidad and UI.anio = HI.anio and UI.activa = true',
                      'type' => 'left'
                  )
              );
              $where = array('HI.anio' => Ranking_dec_model::ANIO,'UI.nivel_atencion' => 3,'HI.denominador >' => 0);
              $group_by = array('PP.nombre');
              $order_by = array('field' => 'porcentaje', 'direction'=>'desc');

              if($peticion['region'] != 'Todos'){
                  $where['UI.id_region'] = $peticion['region'];
              }

              if($peticion['tipos_unidades'] != "Todos")
              {
                  $where['UI.id_tipo_unidad'] = $peticion['tipos_unidades'];
              }

              $parametros = array(
                  'select' => $select,
                  'join' => $join,
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
        return $estado;
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
         if(isset($params['like']))
         {
            //pr($params['like']);
             foreach ($params['like'] as $key => $value)
             {
                 $this->db->like($key, $value, 'none', false);
             }
         }

         if(isset($params['group_by']))
         {
            $this->db->group_by($params['group_by'], false);
         }

         if(isset($params['where_claus']))
         {
                $this->db->where($params['where_claus'],NULL, false);
         }

         if(isset($params['having']))
         {
            $this->db->having($params['having'], false);
         }

         if(isset($params['order_by']))
         {
            $this->db->order_by($params['order_by']['field'], $params['order_by']['direction'], false);
         }


         //$this->db->where('date(fecha) = current_date', null, false);
         if (isset($params['limit']) && isset($params['offset']) && !isset($params['total']))
         {
             $this->db->limit($params['limit'], $params['offset']);
         } else if (isset($params['limit']) && !isset($params['total']))
         {
             $this->db->limit($params['limit']);
         }
         //pr($this->db->result_id->queryString);
         $query = $this->db->get();
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
