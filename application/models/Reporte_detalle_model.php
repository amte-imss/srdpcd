<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_detalle_model extends CI_Model
{

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->config->load('general');
        $this->load->database();
    }

    public function get_carga($filtros = array())
    {
        $this->db->flush_cache(); 
        $this->db->reset_query();

        if (isset($filtros['order']) and !empty($filtros['order'])){
            $this->db->order_by($filtros['order']);
        }

        if (isset($filtros['select']) and !empty($filtros['select'])){
            $this->db->select($filtros['select']);
        } else {
            $this->db->select(array('*'));
        }
        
        $this->db->where('C.car_activo', true);
        $carga = $this->db->get('srdpcd.carga C')->result_array();

        return $carga;
    }

    public function get_implementaciones_alumnos($filtros = array())
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        if (isset($filtros['select']) and !empty($filtros['select'])){
            $this->db->select($filtros['select']);
        }

        if (isset($filtros['where']) and !empty($filtros['where'])){
            $this->db->where($filtros['where']);
        }

        if (isset($filtros['order']) and !empty($filtros['order'])){
            $this->db->order_by($filtros['order']);
        }
        //$this->db->save_queries = TRUE;
        $carga = $this->db->get('srdpcd.implementaciones_alumnos IMAL')->result_array();
        //pr($this->db->last_query()); exit();

        return $carga;
    }

}