<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Indicadores_dec_model extends CI_Model
{
  public function __construct()
  {
    // Call the CI_Model constructor
    parent::__construct();
    //$this->config->load('general');
    $this->load->database();
  }
  /*
  * @author AleSpock
  * @return
  */
  //inserta un nuevo registro a la tabla h_indicadores
  public function nuevo_dec($id_indicador,$cve_presupuestal,$numerador,$denominador,$trimestre,$porcentaje_aprobados,$anio, $id_programa_proyecto,$cve_unidad) {
    $this->db->flush_cache();
    $this->db->reset_query();
    $data = array(
      // 'id_indicador' => $id_indicador,
      'cve_presupuestal' => $cve_presupuestal,
      'numerador' => $numerador,
      'denominador' => $denominador,
      'trimestre' => $trimestre,
      'porcentaje_aprobados' => $porcentaje_aprobados,
      'anio' => $anio,
      'id_programa_proyecto' => $id_programa_proyecto,
      'cve_unidad' => $cve_unidad
    );
    $this->db->insert('dec.h_indicadores',$data);
    return $data;
  }

  // Obtiene los registros de la tabla h_indicadores con los campos id_indicador,$cve_presupuestal,$numerador,$denominador,$trimestre,$porcentaje_aprobados,$anio, $id_programa_proyecto
  public function lista_indicadores_dec() {
    $this->db->flush_cache();
    $this->db->reset_query();
    $this->db->select(array('id_indicador', 'cve_presupuestal', 'numerador', 'denominador', 'trimestre', 'porcentaje_aprobados', 'anio', 'id_programa_proyecto', 'cve_unidad'));
    $indicadores_dec = $this->db->get('dec.h_indicadores')->result_array();
    return $indicadores_dec;
  }

  //actualiza un registro a la tabla h_indicadores
  public function update_registro_dec($id_indicador,$cve_presupuestal,$numerador,$denominador,$trimestre,$porcentaje_aprobados,$anio, $id_programa_proyecto, $cve_unidad) {
    $this->db->flush_cache();
    $this->db->reset_query();
    $data = array(
      'cve_presupuestal' => $cve_presupuestal,
      'numerador' => $numerador,
      'denominador' => $denominador,
      'trimestre' => $trimestre,
      'porcentaje_aprobados' => $porcentaje_aprobados,
      'anio' => $anio,
      'id_programa_proyecto' => $id_programa_proyecto,
      'cve_unidad' => $cve_unidad
    );
    $this->db->where('id_indicador',$id_indicador);
    $this->db->update('dec.h_indicadores',$data);
    if ($this->db->trans_status() === FALSE){
      return -1;
    } else{
      return 0;
    }

  }

  //elimina un registro a la tabla h_indicadores
  public function delete($id_indicador) {
    $this->db->flush_cache();
    $this->db->reset_query();
    $this->db->where('id_indicador',$id_indicador);
    return $this->db->delete('dec.h_indicadores');

  }
  //trae el id del catalogo y el nombre para msotrarse en nombre de proyecto en la tabla h_indicadores

  public function get_catalogos() {
    $this->db->flush_cache();
    $this->db->reset_query();
    $resutado = $this->db->get('catalogos.programas_proyecto');
    return $resutado->result_array();
  }
}
