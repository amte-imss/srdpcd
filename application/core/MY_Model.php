<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*@author: Mr. Guag
*@version: 1.0
*@desc: Clase padre de los controladores del sistema

*	 function model_load_model($model_name)
*   {
*      $CI =& get_instance();
*      $CI->load->model($model_name);
*      return $CI->$model_name;
*   }
**/
class MY_Model extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	*	@author: Christian Garcia
	*	@version: 1.0
	*	@params: $nombre_tabla - nombre de la tabla a modificar, $params = array con
	*	configuración para construir la consulta con BuilderQuery, $where_ids -
	*	Array con los las llaves de los elementos a modificar
	*	@return: array[success, message, data] donde success - bandera para indicar el status de
	*	la transacción, message - el mensaje
	**/
	public function update_registro($nombre_tabla = null, &$params = [], $where_ids = [])
	{
		$this->db->flush_cache();
		$this->db->reset_query();
		$status = array('success' => false, 'message' => 'Nombre de tabla incorrecto', 'data'=>[]);
		if(is_null($nombre_tabla ))
		{
			return $status;
		}
		try
		{
			$this->db->update($nombre_tabla, $params, $where_ids);
			$status['success'] = true;
			$status['message'] = 'Actualizado con éxito';
		}catch(Exception $ex)
		{

		}
		return $status;
	}

	/**
	*	@author: Christian Garcia
	*	@version: 1.0
	*	@params: $nombre_tabla - nombre de la tabla a modificar, $where_ids -
	*	Array con los las llaves de los elementos a eleiminar
	*	@return: array[success, message, data] donde success - bandera para indicar el status de
	*	la transacción, message - el mensaje
	**/
	public function delete_registros($nombre_tabla = null, $where_ids = [])
	{
		$this->db->flush_cache();
		$this->db->reset_query();
		$status = array('success' => false, 'message' => 'Nombre de tabla incorrecto', 'data'=>[]);
		if(is_null($nombre_tabla ))
		{
			return $status;
		}
		try
		{
			foreach ($where_ids as $key => $value)
			{
				$this->db->where($key, $value);
			}
			$this->db->delete($nombre_tabla);
			$status['success'] = true;
			$status['message'] = 'Eliminado con éxito';
		}catch(Exception $ex)
		{

		}
		$this->db->reset_query();
		return $status;
	}

	/**
	*	@author: Christian Garcia
	*	@version: 1.0
	*	@params: $nombre_tabla - nombre de la tabla a modificar, $params = array con
	*	configuración para construir la consulta con BuilderQuery, $return_last_id -
	*	bandera para indicar si se require retornar el nuevo id autoincrementado automaticamente
	*	@return: array[success, message, data] donde success - bandera para indicar el status de
	*	la transacción, message - el mensaje, data es el id
	**/
	public function insert_registro($nombre_tabla = null, &$params = [], $return_last_id = true)
	{
		$this->db->flush_cache();
		$this->db->reset_query();
		$status = array('success' => false, 'message' => 'Nombre de tabla incorrecto', 'data'=>[]);
		if(is_null($nombre_tabla ))
		{
			return $status;
		}

		try
		{
			$this->db->insert($nombre_tabla, $params);
			$status['success'] = true;
			$status['message'] = 'Agregado con éxito';
			if($return_last_id)
			{
				$status['data'] = array('id_elemento' => $this->db->insert_id());
			}
		}catch(Exception $ex)
		{

		}
		return $status;
	}

	public function get_registros($nombre_tabla = null, &$params = [])
   {
	   //pr($params);
	   if(is_null($nombre_tabla ))
	   {
		   return [];
	   }
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
	   $this->db->select($select);
	   if (isset($params['join']))
	   {
		   foreach ($params['join'] as $value)
		   {
			   $this->db->join($value['table'], $value['condition'], $value['type']);
		   }
	   }
	   if (isset($params['where']))
	   {
		   foreach ($params['where'] as $key => $value)
		   {
			   $this->db->where($key, $value);
		   }
	   }
	   if (isset($params['where_not_in']))
	   {
		 foreach ($params['where_not_in'] as $key => $value)
		 {
			 $this->db->where_not_in($key, $value);
		 }
	   }
	   if(isset($params['like']))
	   {
		   foreach ($params['like'] as $key => $value)
		   {
			   $this->db->like($key, $value);
		   }
	   }

	   if(isset($params['group_by']))
	   {
		   	$this->db->group_by($params['group_by']);
	   }

	   if(isset($params['order_by']))
	   {
		   foreach ($params['order_by'] as $value)
		   {
			    $this->db->order_by($value);
		   }

	   }
//        $this->db->where('date(fecha) = current_date', null, false);
	   if (isset($params['limit']) && isset($params['offset']) && !isset($params['total']))
	   {
		   $this->db->limit($params['limit'], $params['offset']);
	   } else if (isset($params['limit']) && !isset($params['total']))
	   {
		   $this->db->limit($params['limit']);
	   }

	   $query = $this->db->get($nombre_tabla);
	   $salida = $query->result_array();
	   $query->free_result();
	   //pr($this->db->last_query());
	   $this->db->flush_cache();
	   $this->db->reset_query();
	   return $salida;
   }
}
