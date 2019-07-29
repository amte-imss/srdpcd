<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene la información de la DEC
 * @version 	: 1.0.0
 * @author      : Cheko
 * */
class Dec extends MY_Controller
{

  function __construct()
  {
      parent::__construct();
      $this->load->helper(array('form', 'general'));
      $this->load->library('form_complete');
      $this->load->library('Configuracion_grupos');
      $this->load->library('Catalogo_listado');
      $this->lang->load('interface'); //Cargar archivo de lenguaje
      $this->load->model('Informacion_general_model', 'inf_gen_model');
      $this->configuracion_grupos->set_periodo_actual();
      //catalogo
      $this->load->model('Catalogo_model', 'catalogo');
      //dec
      $this->load->model('Dec_model','dec');
      //ranking
      $this->load->model('Ranking_dec_model','ranking');
      $this->lang->load('ranking', 'spanish');

  }

  /**
   * Función que muestra la información general de la dec por
   * UMAE o delegacional
   * @author Cheko
   * @param String $nivel nivel que se quiere mostrar (por_delegacion o por_umae)
   *
   */
  public function informacion_general($nivel=NULL)
  {
      switch ($nivel) {
          case 'por_delegacion':
              $this->muestra_por_delegacion();
              break;
          case 'por_umae':
              $this->muestra_por_UMAE();
              break;
          case 'general':
              $this->muestra_general();
              break;
          default:
              $this->muestra_por_delegacion();
              break;
      }
  }

  /**
   * Función que muestra la vista de ranking por el nivel
   * @author Cheko
   *
   */
  public function ranking()
  {
      $output = array();
      $output['ranking'] = 'dec';
      $output['lenguaje'] = $this->lang->line('index');
      $output['usuario'] = $this->session->userdata('usuario');

      //$output['programas'] = dropdown_options($this->ranking->get_programas(), 'id_programa_proyecto', 'proyecto');
      //$output['periodos'] = dropdown_options($this->ranking->get_periodos(), 'periodo', 'periodo');
      if(is_nivel_tactico($output['usuario']['grupos'])){
            $conditions = array('conditions'=>"uni.grupo_tipo_unidad IN ('".$this->config->item('grupo_tipo_unidad')['UMAE']['id']."', '".$this->config->item('grupo_tipo_unidad')['CUMAE']['id']."')");
            $output['usuario']['tactico'] = true;
            $output['usuario']['central'] = false;
            $output['usuario']['estrategico'] = false;
            $this->template->setSubTitle('Ranking por Unidad Médica');

      }else{
          if(is_nivel_estrategico($output['usuario']['grupos'])){
              $conditions = array('conditions'=>"uni.grupo_tipo_unidad NOT IN ('".$this->config->item('grupo_tipo_unidad')['UMAE']['id']."', '".$this->config->item('grupo_tipo_unidad')['CUMAE']['id']."')");
              $output['usuario']['estrategico'] = true;
              $output['usuario']['central'] = false;
              $output['usuario']['tactico'] = false;
              $output['regiones'] = dropdown_options(array(0=>array('id_region'=>$output['usuario']['id_region'],'region'=>'defaul')), 'id_region', 'region');
              $delegaciones = $this->obtener_delegaciones_otro($output['usuario']['id_region']);
              //pr($delegaciones['datos']);
              $output['delegaciones'] = dropdown_options($delegaciones['datos'], 'id_delegacion', 'delegacion');
              $this->template->setSubTitle('Ranking Intrarregional');
          }else{
              $output['usuario']['central'] = true;
              $output['usuario']['estrategico'] = false;
              $output['usuario']['tactico'] = false;
              if($this->catalogo->obtener_regiones()['success'])
              {
                  $regiones = $this->catalogo->obtener_regiones()['datos'];
                  //pr($regiones);
                  $output['regiones'] = dropdown_options($regiones, 'id_region', 'region');
              }
              $this->template->setSubTitle('Ranking por línea prioritaria de atención');
          }
      }

      if ($this->input->post())
      {
          $analisis =$this->input->post('nivel_analisis',true);
          $arreglo_reportes=array('region'=>'','delegacion'=>'','nivel'=>'','asistentes'=>'','tipos_unidades' => '');
          $usuario = $this->session->userdata('usuario');
          if ($this->input->post('umae', true))
          {
              $usuario['umae'] = true;
          }
          $output['filtros'] = $this->input->post(NULL, true);
          // if($output['filtros']['asistentes'] == "realesvsprogramados")
          // {
          //    $output['asistentes'] = 'Asistentes programados vs Asistentes reales';
          // }else{
          //     $output['asistentes'] = 'Porcentaje de aprobados';
          // }
          $output['asistentes'] = 'Asistentes programados vs Asistentes aprobados';

          if(is_nivel_tactico($output['usuario']['grupos'])){
              $arreglo_reportes['region'] = $output['usuario']['id_region'];
              $arreglo_reportes['delegacion'] = $output['usuario']['id_delegacion'];
              //$arreglo_reportes['asistentes'] = $this->input->post('asistentes');
              $arreglo_reportes['asistentes'] = 'realesvsprogramados';
              $arreglo_reportes['nivel'] = $this->input->post('nivel');
              $arreglo_reportes['tipos_unidades'] = $this->input->post('tipos_unidades');
              $output['datos'] = $this->ranking->ranking($usuario, "delegacional",$arreglo_reportes);
              $output['tabla'] = $this->load->view('dec/ranking/tabla', $output, true);
              $output['grafica'] = $this->load->view('dec/ranking/grafica', $output, true);
          }else{
              if(is_nivel_estrategico($output['usuario']['grupos'])){
                $arreglo_reportes['region'] = $output['usuario']['id_region'];
                $arreglo_reportes['delegacion'] = $this->input->post('delegacion');
                //$arreglo_reportes['asistentes'] = $this->input->post('asistentes');
                $arreglo_reportes['asistentes'] = 'realesvsprogramados';
                $arreglo_reportes['nivel'] = $this->input->post('nivel');
                $arreglo_reportes['tipos_unidades'] = $this->input->post('tipos_unidades');
                $delegaciones = $this->obtener_delegaciones_otro($output['usuario']['id_region']);
                $output['delegaciones'] = dropdown_options($delegaciones['datos'], 'id_delegacion', 'delegacion');
                $output['datos'] = $this->ranking->ranking($usuario, $analisis,$arreglo_reportes);
                //pr($output['datos']);
                $output['tabla'] = $this->load->view('dec/ranking/tabla', $output, true);
                $output['grafica'] = $this->load->view('dec/ranking/grafica', $output, true);
              }else{
                  $arreglo_reportes['region'] = 'Todos';
                  //$arreglo_reportes['asistentes'] = $this->input->post('asistentes');
                  $arreglo_reportes['asistentes'] = 'realesvsprogramados';
                  $arreglo_reportes['delegacion'] = $this->input->post('delegacion');
                  $arreglo_reportes['nivel'] = $this->input->post('nivel');
                  $arreglo_reportes['tipos_unidades'] = $this->input->post('tipos_unidades');
                  $output['datos'] = $this->ranking->ranking($usuario, $analisis, $arreglo_reportes);
                  $output['tabla'] = $this->load->view('dec/ranking/tabla', $output, true);
                  $output['grafica'] = $this->load->view('dec/ranking/grafica', $output, true);
              }
          }


      }
      $this->template->setTitle($output['lenguaje']['title']);
      $this->template->setDescripcion($this->mostrar_datos_generales());
      $main_content = $this->load->view('dec/ranking/ranking', $output, true);
      $this->template->setMainContent($main_content);
      $this->template->getTemplate();
      //$this->output->enable_profiler(true);
  }

  /**
   * Función que muestra la vista por delegacion
   * @author Cheko
   *
   */
  private function muestra_por_delegacion()
  {
      $arreglo_reportes=array('region'=>'','delegacion'=>'','nivel'=>'','tipos_unidades'=>'', 'anio'=>'', 'tipo_periodo'=>'', 'periodo'=>'');
      $output = array();
      $output['lenguaje'] = $this->lang->line('index');
      $output['usuario'] = $this->session->userdata('usuario');

      $grupo_actual = $this->configuracion_grupos->obtener_grupo_actual();
      $condicion = [];
      //pr($output['usuario']);
      if(is_nivel_operacional($output['usuario']['grupos'])){
          //echo 'OPERATIVO';
          $output['usuario']['operacional'] = true;
          $output['usuario']['tactico'] = false;
          $output['usuario']['central'] = false;
          $output['usuario']['estrategico'] = false;
      }else{
        if(is_nivel_tactico($output['usuario']['grupos'])){
              $conditions = array('conditions'=>"uni.grupo_tipo_unidad IN ('".$this->config->item('grupo_tipo_unidad')['UMAE']['id']."', '".$this->config->item('grupo_tipo_unidad')['CUMAE']['id']."')");
              $output['usuario']['operacional'] = false;
              $output['usuario']['tactico'] = true;
              $output['usuario']['central'] = false;
              $output['usuario']['estrategico'] = false;
        }else{
            if(is_nivel_estrategico($output['usuario']['grupos'])){
                $conditions = array('conditions'=>"uni.grupo_tipo_unidad NOT IN ('".$this->config->item('grupo_tipo_unidad')['UMAE']['id']."', '".$this->config->item('grupo_tipo_unidad')['CUMAE']['id']."')");
                $output['usuario']['operacional'] = false;
                $output['usuario']['estrategico'] = true;
                $output['usuario']['central'] = false;
                $output['usuario']['tactico'] = false;
                $output['regiones'] = dropdown_options(array(0=>array('id_region'=>$output['usuario']['id_region'],'region'=>'defaul')), 'id_region', 'region');
                $delegaciones = $this->obtener_delegaciones_otro($output['usuario']['id_region']);
                //pr($delegaciones['datos']);
                $output['delegaciones'] = dropdown_options($delegaciones['datos'], 'id_delegacion', 'delegacion');
            }else{
                $output['usuario']['operacional'] = false;
                $output['usuario']['central'] = true;
                $output['usuario']['estrategico'] = false;
                $output['usuario']['tactico'] = false;
                if($this->catalogo->obtener_regiones()['success'])
                {
                    $regiones = $this->catalogo->obtener_regiones()['datos'];
                    //pr($regiones);
                    $output['regiones'] = dropdown_options($regiones, 'id_region', 'region');
                }
            }
        }
      }


      if ($this->input->post())
      {
          $output['periodo'] = $this->obtener_periodo($this->input->post('tipo_periodo', true),$this->input->post('periodo', true), $this->input->post('anio', true));
          $output['filtros'] = $this->input->post(NULL, true);
          $usuario = $this->session->userdata('usuario');

          if(is_nivel_operacional($output['usuario']['grupos'])){
              $region = $this->catalogo->obtener_region($output['usuario']['id_region']);
              $tipoUnidad = $this->catalogo->obtener_tipo_unidad($output['usuario']['id_tipo_unidad']);
              $delegacion = $this->catalogo->obtener_delegacion($output['usuario']['id_delegacion']);
              $output['region'] = count($region['datos']) > 0 ? $region['datos']['nombre'] : "Todos";
              $output['delegacion'] = count($delegacion['datos']) > 0 ? $delegacion['datos']['nombre_grupo_delegacion']: "Todos";
              $output['tipo_unidad'] = count($tipoUnidad['datos']) > 0 ? $tipoUnidad['datos']['nombre'] : "Todos";
              $arreglo_reportes['region'] = $output['usuario']['id_region'];
              $arreglo_reportes['delegacion'] = $output['usuario']['id_delegacion'];
              $arreglo_reportes['tipos_unidades'] = $output['usuario']['id_tipo_unidad'];
              $arreglo_reportes['nivel'] = $output['usuario']['nivel_atencion'];
              $arreglo_reportes['tipo_periodo'] = $this->input->post('tipo_periodo',true);
              $arreglo_reportes['periodo'] = $this->input->post('periodo',true);
              $arreglo_reportes['anio'] = $this->input->post('anio',true);
              //pr($arreglo_reportes);
              $output['datos_totales_unidades'] = $this->dec->reporte_total_unidades($usuario,'delegacion',$arreglo_reportes);
              $output['datos_totales_unidades_con_programa'] = $this->dec->reporte_total_unidades_programa($usuario,'delegacion',$arreglo_reportes);
              if(count($output['datos_totales_unidades']['datos']) > 0 && count($output['datos_totales_unidades_con_programa']['datos'])){
                  $t_unidades = floatval($output['datos_totales_unidades']['datos'][0]['total_unidades']);
                  $tu_programa = floatval($output['datos_totales_unidades_con_programa']['datos'][0]['total_unidades']);
                  if($tu_programa < 1){
                      $output['datos_totales_porcentaje'] = 0.0;
                  }else{
                      $output['datos_totales_porcentaje'] = round(($tu_programa * 100.0)/$t_unidades);
                  }

              }else{
                if(count($output['datos_totales_unidades_con_programa']['datos']) == 0){
                  $output['datos_totales_porcentaje'] = 0.0;
                }
              }

              //para tabular
              $output['datos'] = $this->dec->reporte($usuario,'delegacion',$arreglo_reportes);
              //pr($output['datos']);
              $output['reporte'] = 'delegacion';
              $output['tabla'] = $this->load->view('dec/informacion_general/tabla', $output, true);
          }else{
              if(is_nivel_tactico($output['usuario']['grupos'])){
                  $region = $this->catalogo->obtener_region($output['usuario']['id_region']);
                  $tipoUnidad = $this->catalogo->obtener_tipo_unidad($this->input->post('tipos_unidades'));
                  $delegacion = $this->catalogo->obtener_delegacion($output['usuario']['id_delegacion']);
                  $output['region'] = count($region['datos']) > 0 ? $region['datos']['nombre'] : "Todos";
                  $output['delegacion'] = count($delegacion['datos']) > 0 ? $delegacion['datos']['nombre_grupo_delegacion']: "Todos";
                  $output['tipo_unidad'] = count($tipoUnidad['datos']) > 0 ? $tipoUnidad['datos']['nombre'] : "Todos";
                  $arreglo_reportes['region'] = $output['usuario']['id_region'];
                  $arreglo_reportes['delegacion'] = $output['usuario']['id_delegacion'];
                  $arreglo_reportes['tipos_unidades'] = $this->input->post('tipos_unidades',true);
                  $arreglo_reportes['nivel'] = $this->input->post('nivel',true);
                  $arreglo_reportes['tipo_periodo'] = $this->input->post('tipo_periodo',true);
                  $arreglo_reportes['periodo'] = $this->input->post('periodo',true);
                  $arreglo_reportes['anio'] = $this->input->post('anio',true);
                  $output['datos_totales_unidades'] = $this->dec->reporte_total_unidades($usuario,'delegacion',$arreglo_reportes);
                  $output['datos_totales_unidades_con_programa'] = $this->dec->reporte_total_unidades_programa($usuario,'delegacion',$arreglo_reportes);
                  if(count($output['datos_totales_unidades']['datos']) > 0 && count($output['datos_totales_unidades_con_programa']['datos'])){
                      $t_unidades = floatval($output['datos_totales_unidades']['datos'][0]['total_unidades']);
                      $tu_programa = floatval($output['datos_totales_unidades_con_programa']['datos'][0]['total_unidades']);
                      if($tu_programa < 1){
                          $output['datos_totales_porcentaje'] = 0.0;
                      }else{
                          $output['datos_totales_porcentaje'] = round(($tu_programa * 100.0)/$t_unidades);
                      }

                  }else{
                    if(count($output['datos_totales_unidades_con_programa']['datos']) == 0){
                      $output['datos_totales_porcentaje'] = 0.0;
                    }
                  }

                  //para tabular
                  $output['datos'] = $this->dec->reporte($usuario,'delegacion',$arreglo_reportes);
                  //pr($output['datos']);
                  $output['reporte'] = 'delegacion';
                  $output['tabla'] = $this->load->view('dec/informacion_general/tabla', $output, true);
              }else{
                  if(is_nivel_estrategico($output['usuario']['grupos'])){
                      $region = $this->catalogo->obtener_region($output['usuario']['id_region']);
                      $tipoUnidad = $this->catalogo->obtener_tipo_unidad($this->input->post('tipos_unidades'));
                      $delegacion = $this->catalogo->obtener_delegacion($this->input->post('delegacion'));
                      $output['region'] = count($region['datos']) > 0 ? $region['datos']['nombre'] : "Todos";
                      $output['delegacion'] = count($delegacion['datos']) > 0 ? $delegacion['datos']['nombre_grupo_delegacion']: "Todos";
                      $output['tipo_unidad'] = count($tipoUnidad['datos']) > 0 ? $tipoUnidad['datos']['nombre'] : "Todos";
                      $arreglo_reportes['region'] = $output['usuario']['id_region'];
                      $arreglo_reportes['delegacion'] = $this->input->post('delegacion',true);
                      $arreglo_reportes['tipos_unidades'] = $this->input->post('tipos_unidades',true);
                      $arreglo_reportes['nivel'] = $this->input->post('nivel',true);
                      $arreglo_reportes['tipo_periodo'] = $this->input->post('tipo_periodo',true);
                      $arreglo_reportes['periodo'] = $this->input->post('periodo',true);
                      $arreglo_reportes['anio'] = $this->input->post('anio',true);
                      $output['datos_totales_unidades'] = $this->dec->reporte_total_unidades($usuario,'delegacion',$arreglo_reportes);
                      $output['datos_totales_unidades_con_programa'] = $this->dec->reporte_total_unidades_programa($usuario,'delegacion',$arreglo_reportes);
                      if(count($output['datos_totales_unidades']['datos']) > 0 && count($output['datos_totales_unidades_con_programa']['datos'])){
                          $t_unidades = floatval($output['datos_totales_unidades']['datos'][0]['total_unidades']);
                          $tu_programa = floatval($output['datos_totales_unidades_con_programa']['datos'][0]['total_unidades']);
                          if($tu_programa < 1){
                              $output['datos_totales_porcentaje'] = 0.0;
                          }else{
                              $output['datos_totales_porcentaje'] = round(($tu_programa * 100.0)/$t_unidades);
                          }
                      }else{
                        if(count($output['datos_totales_unidades_con_programa']['datos']) == 0){
                          $output['datos_totales_porcentaje'] = 0.0;
                        }
                      }
                      //para tabular
                      $output['datos'] = $this->dec->reporte($usuario,'delegacion',$arreglo_reportes);
                      //pr($output['datos']);
                      $output['reporte'] = 'delegacion';
                      $output['tabla'] = $this->load->view('dec/informacion_general/tabla', $output, true);
                  }else{
                      $region = $this->catalogo->obtener_region($this->input->post('region'));
                      $tipoUnidad = $this->catalogo->obtener_tipo_unidad($this->input->post('tipos_unidades'));
                      $delegacion = $this->catalogo->obtener_delegacion($this->input->post('delegacion'));
                      $output['region'] = count($region['datos']) > 0 ? $region['datos']['nombre'] : "Todos";
                      $output['delegacion'] = count($delegacion['datos']) > 0 ? $delegacion['datos']['nombre_grupo_delegacion']: "Todos";
                      $output['tipo_unidad'] = count($tipoUnidad['datos']) > 0 ? $tipoUnidad['datos']['nombre'] : "Todos";
                      $output['datos_totales_unidades'] = $this->dec->reporte_total_unidades($usuario,'delegacion',$this->input->post(NULL, true));
                      $output['datos_totales_unidades_con_programa'] = $this->dec->reporte_total_unidades_programa($usuario,'delegacion',$this->input->post(NULL,true));
                      if(count($output['datos_totales_unidades']['datos']) > 0 && count($output['datos_totales_unidades_con_programa']['datos'])){
                          $t_unidades = floatval($output['datos_totales_unidades']['datos'][0]['total_unidades']);
                          $tu_programa = floatval($output['datos_totales_unidades_con_programa']['datos'][0]['total_unidades']);
                          if($tu_programa < 1){
                              $output['datos_totales_porcentaje'] = 0.0;
                          }else{
                              $output['datos_totales_porcentaje'] = round(($tu_programa * 100.0)/$t_unidades);
                          }

                      }else{
                        if(count($output['datos_totales_unidades_con_programa']['datos']) == 0){
                          $output['datos_totales_porcentaje'] = 0.0;
                        }
                      }


                      //para tabular
                      $output['datos'] = $this->dec->reporte($usuario,'delegacion',$this->input->post(NULL, true));
                      //pr($output['datos']);
                      $output['reporte'] = 'delegacion';
                      $output['tabla'] = $this->load->view('dec/informacion_general/tabla', $output, true);
                  }
              }
          }
      }
      $this->template->setTitle($output['lenguaje']['title']);
      $this->template->setSubTitle('Información general por delegación');
      $this->template->setDescripcion($this->mostrar_datos_generales());
      $main_content = $this->load->view('dec/informacion_general/por_delegacion', $output, true);
      $this->template->setMainContent($main_content);
      $this->template->getTemplate();
  }

  /**
   * Funcion que realiza el resuelve la peticion de get tipos de unidades
   * para obtener todos los tipos de unidades por nivel
   * @author Cheko
   * @param string $nivel Nivel de atencion para obtener los tipos de unidades
   */
  public function tipos_unidades($nivel)
  {
      if($this->input->is_ajax_request())
      {
          $tiposUnidades = $this->catalogo->obtener_tipo_unidades($nivel);
          $this->agregar_cabeceras();
          echo json_encode($tiposUnidades);
      }

  }

  /**
   * Funcion que realiza el resuelve la peticion de get tipos de unidades
   * para obtener todos los tipos de unidades por nivel
   * @author Cheko
   * @param string $nivel Nivel de atencion para obtener los tipos de unidades
   */
  public function obtener_delegaciones($region)
  {
      if($this->input->is_ajax_request())
      {
          $tiposUnidades = $this->catalogo->obtener_delegaciones($region);
          $this->agregar_cabeceras();
          echo json_encode($tiposUnidades);
      }
  }

  /**
   * Funcion que realiza el resuelve la peticion de get tipos de unidades
   * para obtener todos los tipos de unidades por nivel
   * @author Cheko
   * @param string $nivel Nivel de atencion para obtener los tipos de unidades
   */
  private function obtener_delegaciones_otro($region)
  {
      $tiposUnidades = $this->catalogo->obtener_delegaciones($region);
      return $tiposUnidades;
  }

  /**
   * Funcion agregar las cabeceras a la peticion
   * @author Cheko
   *
   */
  private function agregar_cabeceras(){
      header('Content-Type: application/json; charset=utf-8;');
  }


  /**
   * Función auxiliar para obtener los periodos
   * de información general
   * @param String $tipo_periodo Es el tipo de periodo (Trimestral, Semestral y Anual)
   * @param String $periodo indice de los periodos
   * @param String $anio Año del periodo
   * @return String Regresa el periodo elegido
   *
   */
  private function obtener_periodo($tipo_periodo, $periodo, $anio){
      switch ($tipo_periodo) {
          case 'Trimestral':
              if($periodo == "1"){
                  return "Enero-Marzo";
              }
              if($periodo == "2"){
                  return "Abril-Junio";
              }
              if($periodo == "3"){
                  return "Julio-Septiembre";
              }
              if($periodo == "4"){
                  return "Octubre-Diciembre";
              }
              break;
          case 'Semestral':
              if($periodo == "1"){
                  return "Enero-Junio";
              }
              if($periodo == "2"){
                  return "Julio-Diciembre";
              }
              break;
          case 'Anual':
              return $anio;
              break;
          default:
              return "No hay periodo";
              break;
      }
  }

  /**
   * Función que muestra la vista por UMAE
   * @author Cheko
   *
   */
  private function muestra_por_UMAE()
  {
      $output = array();
      $output['lenguaje'] = $this->lang->line('index');
      $output['usuario'] = $this->session->userdata('usuario');
      //pr($output['usuario']);
      if (is_nivel_central($output['usuario']['grupos']))
      {
          $output['usuario']['central'] = true;
      }
      if($this->catalogo->obtener_tipo_unidades('3')['success'])
      {
          $tipos_unidades = $this->catalogo->obtener_tipo_unidades('3')['datos'];
          $output['tipos_unidades'] = dropdown_options($tipos_unidades, 'id_tipo_unidad', 'nombre');
      }

      if(is_nivel_estrategico($output['usuario']['grupos'])){
          $conditions = array('conditions'=>"uni.grupo_tipo_unidad NOT IN ('".$this->config->item('grupo_tipo_unidad')['UMAE']['id']."', '".$this->config->item('grupo_tipo_unidad')['CUMAE']['id']."')");
          $output['usuario']['estrategico'] = true;
          $output['usuario']['central'] = false;
          $output['usuario']['tactico'] = false;
          $output['regiones'] = dropdown_options(array(0=>array('id_region'=>$output['usuario']['id_region'],'region'=>'defaul')), 'id_region', 'region');
          $delegaciones = $this->obtener_delegaciones_otro($output['usuario']['id_region']);
          //pr($delegaciones['datos']);
          $output['delegaciones'] = dropdown_options($delegaciones['datos'], 'id_delegacion', 'delegacion');
      }else{
          if(is_nivel_central($output['usuario']['grupos'])){
              $output['usuario']['central'] = true;
              $output['usuario']['estrategico'] = false;
              $output['usuario']['tactico'] = false;
              if($this->catalogo->obtener_regiones()['success'])
              {
                  $regiones = $this->catalogo->obtener_regiones()['datos'];
                  //pr($regiones);
                  $output['regiones'] = dropdown_options($regiones, 'id_region', 'region');
              }
          }
      }
      if ($this->input->post())
      {
          $output['periodo'] = $this->obtener_periodo($this->input->post('tipo_periodo', true),$this->input->post('periodo', true), $this->input->post('anio', true));
          if(is_nivel_estrategico($output['usuario']['grupos'])){
            //pr($output['usuario']);
            $usuario = $this->session->userdata('usuario');
            $tipoUnidad = $this->catalogo->obtener_tipo_unidad($this->input->post('tipos_unidades'));
            $output['filtros'] = $this->input->post(NULL, true);
            $output['tipo_unidad'] = count($tipoUnidad['datos']) > 0 ? $tipoUnidad['datos']['nombre'] : "Todos";
            $arreglo_reportes['region'] = $output['usuario']['id_region'];
            $arreglo_reportes['delegacion'] = $output['usuario']['grupo_delegacion'];
            $arreglo_reportes['tipos_unidades'] = $this->input->post('tipos_unidades');
            $arreglo_reportes['nivel'] = 3;
            $arreglo_reportes['tipo_periodo'] = $this->input->post('tipo_periodo',true);
            $arreglo_reportes['periodo'] = $this->input->post('periodo',true);
            $arreglo_reportes['anio'] = $this->input->post('anio',true);
            $output['datos_totales_unidades'] = $this->dec->reporte_total_unidades($usuario,'umae',$arreglo_reportes);
            $output['datos_totales_unidades_con_programa'] = $this->dec->reporte_total_unidades_programa($usuario,'umae',$arreglo_reportes);
            //pr($output['datos_totales_unidades']);
            //pr($output['datos_totales_unidades_con_programa']);
            if(count($output['datos_totales_unidades']['datos']) > 0 && count($output['datos_totales_unidades_con_programa']['datos'])){
                $t_unidades = floatval($output['datos_totales_unidades']['datos'][0]['total_unidades']);
                $tu_programa = floatval($output['datos_totales_unidades_con_programa']['datos'][0]['total_unidades']);
                if($tu_programa < 1){
                    $output['datos_totales_porcentaje'] = 0.0;
                }else{
                    $output['datos_totales_porcentaje'] = round(($tu_programa * 100.0)/$t_unidades);
                }
            }else{
              if(count($output['datos_totales_unidades_con_programa']['datos']) == 0){
                $output['datos_totales_porcentaje'] = 0.0;
              }
            }

            //para tabular
            $output['datos'] = $this->dec->reporte($usuario,'umae',$arreglo_reportes);
            //pr($output['datos']);
            $output['reporte'] = 'umae';
            $output['tabla'] = $this->load->view('dec/informacion_general/tabla', $output, true);
          }else{
              if(is_nivel_central($output['usuario']['grupos'])){
                  $usuario = $this->session->userdata('usuario');
                  $tipoUnidad = $this->catalogo->obtener_tipo_unidad($this->input->post('tipos_unidades'));
                  $output['filtros'] = $this->input->post(NULL, true);
                  $output['tipo_unidad'] = count($tipoUnidad['datos']) > 0 ? $tipoUnidad['datos']['nombre'] : "Todos";
                  $arreglo_reportes['region'] = 'Todos';
                  $arreglo_reportes['delegacion'] = 'Todos';
                  $arreglo_reportes['tipos_unidades'] = $this->input->post('tipos_unidades');
                  $arreglo_reportes['nivel'] = 3;
                  $arreglo_reportes['tipo_periodo'] = $this->input->post('tipo_periodo',true);
                  $arreglo_reportes['periodo'] = $this->input->post('periodo',true);
                  $arreglo_reportes['anio'] = $this->input->post('anio',true);
                  $output['datos_totales_unidades'] = $this->dec->reporte_total_unidades($usuario,'umae',$arreglo_reportes);
                  $output['datos_totales_unidades_con_programa'] = $this->dec->reporte_total_unidades_programa($usuario,'umae',$arreglo_reportes);
                  //pr($output['datos_totales_unidades']);
                  //pr($output['datos_totales_unidades_con_programa']);
                  if(count($output['datos_totales_unidades']['datos']) > 0 && count($output['datos_totales_unidades_con_programa']['datos'])){
                      $t_unidades = floatval($output['datos_totales_unidades']['datos'][0]['total_unidades']);
                      $tu_programa = floatval($output['datos_totales_unidades_con_programa']['datos'][0]['total_unidades']);
                      if($tu_programa < 1){
                          $output['datos_totales_porcentaje'] = 0.0;
                      }else{
                          $output['datos_totales_porcentaje'] = round(($tu_programa * 100.0)/$t_unidades);
                      }
                  }else{
                    if(count($output['datos_totales_unidades_con_programa']['datos']) == 0){
                      $output['datos_totales_porcentaje'] = 0.0;
                    }
                  }

                  //para tabular
                  $output['datos'] = $this->dec->reporte($usuario,'umae',$arreglo_reportes);
                  //pr($output['datos']);
                  $output['reporte'] = 'umae';
                  $output['tabla'] = $this->load->view('dec/informacion_general/tabla', $output, true);
              }
          }

      }
      $this->template->setTitle($output['lenguaje']['title']);
      $this->template->setSubTitle('Información general por UMAE'); //cambiar titulo
      $this->template->setDescripcion($this->mostrar_datos_generales());
      $main_content = $this->load->view('dec/informacion_general/por_unidad', $output, true);
      $this->template->setMainContent($main_content);
      $this->template->getTemplate();
  }
}
