<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona las sesiones
 * @version 	: 2.0
 * @author      : MAGG
 * */
class Welcome extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->load->model('User_model', 'usr');
        $this->lang->load('session', 'spanish');
    }

    function index($code = null)
    {
        //load idioma
        $data["texts"] = $this->lang->line('formulario'); //textos del formulario
        //validamos si hay datos
        if ($this->input->post() && $code == null && $this->input->post("recovery") == null)
        {
            $post = $this->input->post();

            $this->config->load('form_validation'); //Cargar archivo con validaciones
            $validations = $this->config->item('login'); //Obtener validaciones de archivo general
            $this->form_validation->set_rules($validations);

            if ($this->form_validation->run() == TRUE)
            {
                $valido = $this->usr->validar_user($post["usuario"], $post["password"]);
                $mensajes = $this->lang->line('mensajes');
                switch ($valido)
                {
                    case 1:
                        //redirect to home //load menu...etc etc
                        $usuario = $this->usr->get_datos_usuario($post['usuario']);
                        $this->session->set_userdata('usuario', $usuario);
                        //pr($usuario);
                        redirect(site_url() . '/welcome/dashboard');
                        break;
                    case 2:
                        $this->session->set_flashdata('flash_password', $mensajes[$valido]);
                        $data['errores'] = 'password';
                        break;
                    case 3:
                        $this->session->set_flashdata('flash_usuario', $mensajes[$valido]);
                        $data['errores'] = 'usuario';
                        break;
                }
            } else
            {
                $data['errores'] = validation_errors();
            }
        }

        $usuario = $this->session->userdata('usuario');
        if (isset($usuario['id_usuario']))
        {
            redirect(site_url() . '/welcome/dashboard');
        } else
        {
            //cargamos plantilla

            $data['modal_recovery'] = $this->recuperar_password($code);
            if ($code != null)
            {
                $data['code_recovery'] = true;
            }
            if ($this->input->post("recovery") != null)
            {
                $data['user_recovery'] = true;
            }
            $this->template->setTitle($data["texts"]["title"]);

            $this->template->setSubTitle($data["texts"]["subtitle"]);
            $this->template->setDescripcion($data["texts"]["descripcion"]);

            $this->template->setMainContent("tc_template/login_v2.tpl.php", $data, FALSE);
            //$this->template->setBlank("tc_template/index.tpl.php");

            $this->template->getTemplate(null, "tc_template/blank.tpl.php");
        }
    }

    public function plan()
    {
        $data = [];
        $this->config->load('general'); //Cargar archivo con ruta del plan de implementaciones   
        $this->load->model('Reportes_estaticos_model', 'reporte');
        $data['url_plan'] = $this->config->item('plan_implementaciones_url'); //plan de implementaciones por default
        $data['plan_cargado'] = $this->reporte->get_mark_file(Reportes_estaticos_model::PLAN_IMPLEMENTACIONES);
        $this->template->setSubTitle('Plan de implementación');
        $view = $this->load->view("welcome/plan_implementaciones.tpl.php", $data, true);
        $this->template->setMainContent($view);
        $this->template->getTemplate();
    }

    public function documento($tipo=null)
    {
        $data = [];
        $this->config->load('general'); //Cargar archivo con ruta del plan de implementaciones
        $this->load->model('Reportes_estaticos_model', 'reporte');
        if(!empty(trim($tipo)) && !is_int($tipo) && !is_null($tipo)) {
            $data['url_plan'] = $this->config->item('plan_implementaciones_url'); //plan de implementaciones por default
            $data['plan_cargado'] = $this->reporte->get_mark_file($tipo);
            if($data['plan_cargado']['id_reporte_estatico']>0){
                $this->template->setSubTitle($data['plan_cargado']['nombre']);
                $view = $this->load->view("welcome/plan_implementaciones.tpl.php", $data, true);
            } else {
                $view = null;
            }
        } else {
            $view = null;
        }
        $this->template->setMainContent($view);
        $this->template->getTemplate();
    }

    function recargar_captcha()
    {
        $this->load->library('captcha');
        $data['captcha'] = $this->captcha->main();
        $this->session->set_userdata('captchaWord', $data['captcha']);
    }

    /*function dashboard()
    {
        $output = [];
        $view = $this->load->view('welcome/dashboard', $output, true);
        $this->template->setDescripcion($this->mostrar_datos_generales());
        $this->template->setMainContent($view);
        $this->template->setSubTitle('Inicio');
        $this->template->getTemplate();
    }*/

    function dashboard()
    {
        $output = [];
        $this->load->model('Reporte_detalle_model', 'rep_det');
        $output['cargas'] = $this->rep_det->get_carga(array('order'=>2));
        $view = $this->load->view('welcome/reporte_detalle', $output, true);
        ///s$this->template->setDescripcion($this->mostrar_datos_generales());
        $this->template->setMainContent($view);
        $this->template->setSubTitle('Sistema de Reportes de Desarrollo Profesional Continuo a Distancia');
        $this->template->setDescripcion($this->mostrar_datos_generales());
        $this->template->getTemplate();
    }

    public function reporte_detalle($tipo=null){
        //pr($this->session->userdata('usuario'));
        $this->load->model('Reporte_detalle_model', 'rep_det');
        $this->load->library('Configuracion_grupos');
        $grupo_actual = $this->configuracion_grupos->obtener_grupo_actual();
        //$this->configuracion_grupos->set_periodo_actual();
        $filtros = array('select'=>'imal_clave_implementacion, imal_curso, imal_fecha_inicio_curso, imal_fecha_fin_curso, imal_matricula, imal_apellido_paterno,imal_apellido_materno,imal_nombre, imal_categoria,imal_adscripcion,imal_unidad,imal_delegacion,imal_folio_certificado',
            'order'=>'imal_clave_implementacion desc, imal_fecha_inicio_curso, imal_fecha_fin_curso');
        switch ($grupo_actual) {
            case En_grupos::NIVEL_CENTRAL: case En_grupos::ADMIN: case En_grupos::SUPERADMIN:
                if($grupo_actual== En_grupos::SUPERADMIN and $tipo=='all'){
                    $filtros['select'] = '*';
                }
            break;
            default:
                //case En_grupos::N2_CPEI: case En_grupos::N2_DGU: case En_grupos::N2_CAME: case En_grupos::N3_JSPM: ///Se utlizó el mismo nivel
                if(in_array($grupo_actual, array(En_grupos::N2_CPEI, En_grupos::N2_CAME, En_grupos::N3_JSPM))) { //Si es unidad, tiene diferentes condicionales a las de una UMAE
                    $filtros['where'] = "IMAL.imal_clave_delegacion='".$this->configuracion_grupos->obtener_clave_delegacion_actual()."'";
                } else {
                    $filtros['where'] = "IMAL.imal_clave_unidad='".$this->configuracion_grupos->obtener_clave_unidad_actual()."'";
                }
                /*if($this->configuracion_grupos->obtener_is_umae()){ //Validar si pertenece a UMAE

                } else { //Validar si es delegacional
                    $filtros['where'] = "IMAL.imal_clave_delegacion='".$this->configuracion_grupos->obtener_clave_delegacion_actual()."'";
                }*/
            break;
        }

        $datos['datos'] = $this->rep_det->get_implementaciones_alumnos($filtros);
        //pr($datos);
        //exit();
        $filename = "reporte_detalle_" . date("d-m-Y_H-i-s") . ".xls";
        //header("Content-Type: application/vnd.ms-excel;charset=UTF-8");
        header("Content-type: application/x-msexcel;charset=UTF-8");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo "\xEF\xBB\xBF"; //UTF-8 BOM
        echo $this->load->view('welcome/reporte_detalle_export', $datos, TRUE);
        exit();
    }

    function cerrar_sesion()
    {
        $this->session->sess_destroy();
        redirect(site_url());
    }

    private function recuperar_password($code = null)
    {
        $datos = array();
        if ($this->input->post() && $code == null && $this->input->post("recovery") != null)
        {
            $usuario = $this->input->post("usuario", true);
            $this->form_validation->set_rules('usuario', 'Usuario', 'required');
            if ($this->form_validation->run() == TRUE)
            {
                $this->usr->recuperar_password($usuario);
                $datos['recovery'] = true;
            }
        } else if ($this->input->post() && $code != null)
        {
            $this->form_validation->set_rules('new_password', 'Constraseña', 'required');
            $this->form_validation->set_rules('new_password_confirm', 'Confirmar constraseña', 'required');
            if ($this->form_validation->run() == TRUE)
            {
                $new_password = $this->input->post('new_password', true);
                $datos['success'] = $this->usr->update_password($code, $new_password);
            }
        } else if ($code != null)
        {
            $datos['code'] = $code;
            $datos['form_recovery'] = true;
        }
        $view = $this->load->view("tc_template/recuperar_password.tpl.php", $datos, true);
        return $view;
    }

}
