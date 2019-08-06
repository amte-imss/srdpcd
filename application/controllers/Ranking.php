<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ranking
 *
 * @author chrigarc
 */
class Ranking extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_complete');
        $this->load->library('Catalogo_listado');
        $this->load->model('Ranking_model', 'ranking');
        $this->lang->load('ranking', 'spanish');
    }

    public function index()
    {
        $output = array();
        $output['lenguaje'] = $this->lang->line('index');
        $output['usuario'] = $this->session->userdata('usuario');
//        pr($output['usuario']);
        if (is_nivel_central($output['usuario']['grupos']))
        {
            $output['usuario']['central'] = true;
        }
        $output['programas'] = dropdown_options($this->ranking->get_programas(), 'id_programa_proyecto', 'proyecto');
        $output['periodos'] = dropdown_options($this->ranking->get_periodos(), 'periodo', 'periodo');
        $output['graficas'] = $this->ranking->get_tipos_reportes();

        if ($this->input->post())
        {
            $usuario = $this->session->userdata('usuario');
            if ($this->input->post('umae', true))
            {
                $usuario['umae'] = true;
            }
            $output['datos'] = $this->ranking->get_data($usuario, $this->input->post(null, true));
            $output['filtros'] = $this->input->post(null, true);
            $output['tabla'] = $this->load->view('ranking/tabla', $output, true);
            $output['grafica'] = $this->load->view('ranking/grafica', $output, true);
            if($this->input->post('periodo') != null && $this->input->post('programa') != null){
                $filtros_['anio'] = $this->input->post('periodo', true);
                $filtros_['id_programa_proyecto'] = $this->input->post('programa', true);
                $output['lista_cursos'] = $this->ranking->get_cursos($filtros_);
                $output['lista_cursos'] = $this->load->view('ranking/cursos.tpl.php', $output, true);
            }
        }
        $this->template->setTitle($output['lenguaje']['title']);
        $this->template->setSubTitle(render_subtitle($output['lenguaje']['subtitle'], 'ranking'));
        $this->template->setDescripcion($this->mostrar_datos_generales());
        $main_content = $this->load->view('ranking/index', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
        //$this->output->enable_profiler(true);
    }

    public function cursos($id = 0, $anio = 2017)
    {
        $filtros['id_programa_proyecto'] = $id;
        $filtros['anio'] = $anio;
        $output['lista_cursos'] = $this->ranking->get_cursos($filtros);
        $this->load->view('ranking/cursos_modal.tpl.php', $output);
    }

    /**
    * Información correspondiente a la DEC, ranking mostrado por programa educativo
    **/
    public function programa_educativo(){
        $output = array();
        $output['lenguaje'] = $this->lang->line('index');
        $output['usuario'] = $this->session->userdata('usuario');
//        pr($output['usuario']);
        if (is_nivel_central($output['usuario']['grupos']))
        {
            $output['usuario']['central'] = true;
        }
        $output['programas'] = dropdown_options($this->ranking->get_programas(), 'id_programa_proyecto', 'proyecto');
        $output['periodos'] = dropdown_options($this->ranking->get_periodos(), 'periodo', 'periodo');
        $output['niveles'] = $this->ranking->get_niveles();
        //$output['graficas'] = $this->ranking->get_tipos_reportes();

        if ($this->input->post())
        {
            $usuario = $this->session->userdata('usuario');
            if ($this->input->post('umae', true))
            {
                $usuario['umae'] = true;
            }
            $output['datos'] = $this->ranking->get_data($usuario, $this->input->post(null, true));
            $output['filtros'] = $this->input->post(null, true);
            $output['tabla'] = $this->load->view('ranking/tabla', $output, true);
            $output['grafica'] = $this->load->view('ranking/grafica', $output, true);
            if($this->input->post('periodo') != null && $this->input->post('programa') != null){
                $filtros_['anio'] = $this->input->post('periodo', true);
                $filtros_['id_programa_proyecto'] = $this->input->post('programa', true);
                $output['lista_cursos'] = $this->ranking->get_cursos($filtros_);
                $output['lista_cursos'] = $this->load->view('ranking/cursos.tpl.php', $output, true);
            }
        }
        $this->template->setTitle($output['lenguaje']['title']);
        $this->template->setSubTitle(render_subtitle($output['lenguaje']['subtitle'], 'ranking'));
        $this->template->setDescripcion($this->mostrar_datos_generales());
        $main_content = $this->load->view('ranking/dec/programa_educativo', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    public function continua()
    {
        $output['lenguaje'] = $this->lang->line('continua');
        $output['usuario'] = $this->session->userdata('usuario');
        $usuario = $output['usuario'];
        if($this->input->post())
        {
            $post = $this->input->post(null, true);

            if(is_nivel_estrategico($usuario['grupos']) && $post['umae'] == 1)
            {
                $post['id_region'] = $usuario['id_region'];
            }else if(is_nivel_tactico($usuario['grupos']) /*|| true*/)
            {
                $post['umae'] = '1';
                $post['delegacion'] = $usuario['grupo_delegacion'];

            }
            $output['result'] = $this->ranking->get_data_continua($post);
            // pr($output['result']);
            $output['params'] = $post;
            //pr($output['params']);
            $this->load->view('ranking/dec/grafica.tpl.php', $output, false);
        }else
        {
            $this->template->setSubTitle("Ranking por unidad");
            if(is_nivel_tactico($usuario['grupos'])){
                $this->template->setSubTitle('Ranking por Unidad Médica');
            }
            if(is_nivel_estrategico($usuario['grupos'])){
              $this->template->setSubTitle('Ranking Intrarregional');
            }
            $this->template->setTitle($output['lenguaje']['title']);
            $this->template->setDescripcion($this->mostrar_datos_generales());
            $output['opciones_filtros'] = $this->opciones_filtros('continua');
            $output['filtros'] = [];
            $output['filtros']['nivel_central'] = $this->load->view('ranking/dec/filtros_nivel_central.tpl.php', $output, true);
            $output['filtros']['estrategico'] = $this->load->view('ranking/dec/filtros_nivel_estrategico.tpl.php', $output, true);
            $output['filtros']['tactico'] = $this->load->view('ranking/dec/filtros_nivel_tactico_unidad.tpl.php', $output, true);
            // $output['lista_filtros'] = true;
            // pr($output['opciones_filtros']);
            $main_content = $this->load->view('ranking/dec/index.tpl.php', $output, true);
            $this->template->setMainContent($main_content);
            $this->template->getTemplate();
        }
    }


    private function opciones_filtros($division = '')
    {
        $salida = [];
        $this->config->load('opciones_filtros');
        switch ($division) {
            case 'continua':
                $salida = $this->config->item('ranking_continua');
                $salida = array_merge($this->ranking->get_filtros_continua(), $salida);
                // pr($salida);
                break;

            default:
                # code...
                break;
        }
        // pr($salida);
        return $salida;
    }
}
