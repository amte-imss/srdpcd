<?php
/*Gestion de la tabla para indicadores DEC
* @author AleSpock
* @
*/
defined('BASEPATH') OR exit('No direct script access allowed');


class Indicadores_dec extends MY_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model('Indicadores_dec_model', 'indicadores_dec'); // lee el modelo Indicadores_dec_model y le asigna un alias
  }

  public function index() {
    $output = [];
    $view = $this->load->view('administracion/indicadores_dec.php', $output, true); //lee la vista indicadores_dec
    $this->template->setDescripcion($this->mostrar_datos_generales()); // muestra los datos generales del usuario en la parte superior del contenido
    $this->template->setMainContent($view);
    $this->template->setSubTitle('Indicadores DEC');
    $this->template->getTemplate();
  }

   /* Obtiene todos lso registros dentro de la tabla h_indicadores y los muestra
   */
  public function mostrar_dec() {
    $array_data = $this->indicadores_dec->lista_indicadores_dec();
    header('Content-Type: application/json; charset=utf-8;');
    echo json_encode($array_data);
  }

  /* elimina el registro seleccionado dentro de la tabla h_indicadores
  */
  public function eliminar_dec()
  {
    //comprobamos si es una petición ajax y existe la variable post id
    if($this->input->is_ajax_request() && $this->input->post('id_indicador', TRUE)) {
      $id_indicador = $this->input->post('id_indicador', TRUE);
      $this->indicadores_dec->delete($id_indicador);
    }
  }

  public function actualizar_dec() {
    $id_indicador = $this->input->post('id_indicador', TRUE);
    // pr ($id_indicador);
    $cve_presupuestal = $this->input->post('cve_presupuestal', TRUE);
    $numerador = $this->input->post('numerador', TRUE);
    $denominador = $this->input->post('denominador', TRUE);
    $trimestre = $this->input->post('trimestre', TRUE);
    $porcentaje_aprobados = $this->input->post('porcentaje_aprobados', TRUE);
    $anio = $this->input->post('anio', TRUE);
    $id_programa_proyecto = $this->input->post('id_programa_proyecto', TRUE);
    $cve_unidad = $this->input->post('cve_unidad', TRUE);
    $actualizar = $this->indicadores_dec->update_registro_dec($id_indicador,$cve_presupuestal,$numerador,$denominador,$trimestre,$porcentaje_aprobados,$anio, $id_programa_proyecto, $cve_unidad);
    header('Content-Type: application/json; charset=utf-8;');
    echo json_encode($actualizar);


  }
  public function nuevo_dec(){
    // $id_indicador = $this->input->post('id_indicador');
    $cve_presupuestal = $this->input->post('cve_presupuestal', TRUE);
    $numerador = $this->input->post('numerador', TRUE);
    $denominador = $this->input->post('denominador', TRUE);
    $trimestre = $this->input->post('trimestre', TRUE);
    $porcentaje_aprobados = $this->input->post('porcentaje_aprobados', TRUE);
    $anio = $this->input->post('anio', TRUE);
    $id_programa_proyecto = $this->input->post('id_programa_proyecto', TRUE);
    $cve_unidad = $this->input->post('cve_unidad', TRUE);
    $nuevo_dec = $this->indicadores_dec->nuevo_dec($cve_presupuestal,$numerador,$denominador,$trimestre,$porcentaje_aprobados,$anio,$id_programa_proyecto, $cve_unidad);
    header('Content-Type: application/json; charset=utf-8;');
    echo json_encode($nuevo_dec);
  }

  public function mostrar_catalogos_proy() {
    $data ['datos_cat'] = $this->indicadores_dec->get_catalogos();
    header('Content-Type: application/json; charset=utf-8;');
    echo json_encode($data);
    // $catalogos = $this->indicadores_dec->get_catalogos('catalogos.programas_proyecto', $c_query);
    //           array_unshift($catalogos,  array('id_programa_proyecto' => '', 'nombre' => 'Seleccionar'));
    //           $output['var_js'] = array(
    //               array(
    //                   "nombre" => 'json_catalogos',
    //                   'value' => json_encode($catalogos)
    //               )
    //           );
  }

}
