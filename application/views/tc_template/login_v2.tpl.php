<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo isset($texts["title"]) ? $texts["title"] . "::" : ""; ?>Sistema de Reportes de Desarrollo Profesional Continuo a Distancia</title>
        <link href="<?php echo base_url(); ?>assets/login/fonts.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/login/bootstrap.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>assets/login/styles_tablero_control.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/login/style_sesion_v2.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/login/securimage.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/third-party/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>assets/tablero_tpl/js/jquery-3.1.0.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/tablero_tpl/js/bootstrap.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            var img_url_loader = "<?php echo img_url_loader('loading.gif'); ?>";
            var site_url = "<?php echo site_url(); ?>";
            /*if (typeof (Storage) !== "undefined") {
                console.log('colocando para: ' + sessionStorage.menu_active);
                if (sessionStorage.menu_active) {
                    sessionStorage.menu_active = "";
                }
            }*/
        </script>
        <?php echo js("general.js"); ?>
        <?php echo js("captcha.js"); ?>
        <?php //echo js("login_animation.js"); ?>
        <?php echo js("login.js"); ?>
        <style type="text/css">
            .text-cores-bottom {
                color:#333333;
                font-size: 14px;
            }
        </style>
        <!-- Google Analytics -->
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-107669218-1', 'auto');
            ga('send', 'pageview');
        </script>
        <!-- End Google Analytics -->
    </head>

    <body>
        <header>
            <nav class="navbar navbar-inverse" role="navigation"><div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarMainCollapse">
                    <span class="sr-only">Interruptor de Navegación</span><span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="logos" style="width: 8rem; margin-top: -2%; margin-bottom: -2%; margin-left: -15%;" href="https://www.gob.mx/" target="_blank">
                    <img src="https://framework-gb.cdn.gob.mx/landing/img/logoheader.png" alt="logo gobierno de méxico">
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarMainCollapse">
                    <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="https://www.gob.mx/tramites" title="Trámites">Trámites</a>
                    </li>
                    <li>
                        <a href="https://www.gob.mx/gobierno" title="Gobierno">Gobierno</a>
                    </li>
                    
                    <li>
                        <a href="https://www.gob.mx/busqueda">
                        <img src="https://framework-gb.cdn.gob.mx/landing/img/lupa.png" alt="">
                        </a>
                    </li>
                    </ul>
                </div>
            </nav>

            <div class="navbar navbar-inverse sub-navbar">
                <div class="container-fluid">
                    <div class="container" style="padding-left: 0px; line-height:45px;">
                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style="padding-left: 0px;">
                            <img src="<?php echo base_url(); ?>assets/tablero_tpl/img/ces.png" width="65px">
                            <img src="<?php echo base_url(); ?>assets/tablero_tpl/img/imss.png">
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
                            <a class="cores-acceso" href="#" data-toggle="modal" data-target="#myModal">Acceso <i class="fa fa-bars" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <!--div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                    <div class="collapse in navbar-collapse" id="navbar-1">
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 " style="padding:0px;">
                            <div class="region region-navigation">
                                <section id="block-superfish-1" class="block block-superfish clearfix">
                                <ul id="superfish-1" class="menu nav navbar-nav sf-menu sf-main-menu sf-horizontal sf-style-space sf-total-items-5 sf-parent-items-0 sf-single-items-5 superfish-processed sf-js-enabled sf-shadow"><li id="menu-238-1" class="active-trail first odd sf-item-1 sf-depth-1 sf-no-children"><a href="/es" class="sf-depth-1 active">Inicio</a></li><li id="menu-728-1" class="middle even sf-item-2 sf-depth-1 sf-no-children"><a href="/es/coordinaci%C3%B3n-de-educaci%C3%B3n-en-salud" title="" class="sf-depth-1">Conócenos</a></li><li id="menu-1917-1" class="middle odd sf-item-3 sf-depth-1 sf-no-children"><a href="/es/normatividad" class="sf-depth-1">Normatividad</a></li><li id="menu-1231-1" class="middle even sf-item-4 sf-depth-1 sf-no-children"><a href="/es/faq" title="" class="sf-depth-1">Preguntas frecuentes</a></li><li id="menu-955-1" class="last odd sf-item-5 sf-depth-1 sf-no-children"><a href="/es/contacto" title="" class="sf-depth-1">Contacto</a></li></ul>	</section>
                            </div>
                                                    </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <div id="capa_buscar" class="navbar-form navbar-right" role="search">
                                    <div class="region region-main-search">
                                        <section id="block-search-form" class="block block-search clearfix">
                                            <form class="search-form form-search content-search" role="search" action="/" method="post" id="search-block-form" accept-charset="UTF-8" target="_self"><div><div>
                                                <h2 class="element-invisible">Formulario de búsqueda</h2>
                                                <div class="input-group"><input title="Escriba lo que quiere buscar." class="custom-search-box form-control form-text" placeholder="Buscar" type="text" id="edit-search-block-form--2" name="search_block_form" value="" size="11" maxlength="128"><span class="input-group-btn"><button type="submit" class="btn btn-primary"><span class="icon glyphicon glyphicon-search" aria-hidden="true"></span>
                                                    </button></span></div>
                                                <div class="form-actions form-wrapper form-group" id="edit-actions"><button class="element-invisible btn btn-primary form-submit" type="submit" id="edit-submit" name="op" value="Buscar">Buscar</button>
                                                </div><input type="hidden" name="form_build_id" value="form-k7tOr6rNQGXSgMZ2Ajla6m6JQz_RDKvKOOJ_54hetmA">
                                                <input type="hidden" name="form_id" value="search_block_form">
                                                </div>
                                                </div>
                                            </form>
                                        </section>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div-->
                </div>
            </div> 
        </header>
        <!-- Modal recuperar contraseña -->
        <div class="modal fade" id="modalRecovery" tabindex="1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="col-md-12">
                            <img class="cores-logo" src="<?php echo base_url(); ?>assets/tablero_tpl/img/ces.png">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">Cerrar <span aria-hidden="true">&times;</span></button>
                        </div>
                    </div>
                    <div class="modal-body cores-recovery-modal">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $modal_recovery; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin Modal recuperar contraseña -->

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="col-md-12">
                            <img class="cores-logo" src="<?php echo base_url(); ?>assets/tablero_tpl/img/ces.png">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">Cerrar <span aria-hidden="true">&times;</span></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">
                                Inicio de sesión
                                <div class="login-html">
                                    <div class="login-form">
                                        <?php echo form_open('welcome/index', array('id' => 'session_form', 'autocomplete' => "off")); ?>
                                        <div class="sign-in-htm">
                                            <div class="group">
                                                <!--label for="user" class="label">Usuario:</label-->
                                                <input id="usuario"
                                                       name="usuario"
                                                       type="text"
                                                       class="input"
                                                       autocomplete="off"
                                                       placeholder="<?php echo $texts['user']; ?>:">

                                            </div>
                                            <?php
                                            echo form_error_format('usuario');
                                            if ($this->session->flashdata('flash_usuario'))
                                            {
                                                ?>
                                                <div class="alert alert-danger" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <?php echo $this->session->flashdata('flash_usuario'); ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="group">
                                                <!--label for="pass" class="label">Contraseña:</label-->
                                                <input id="password"
                                                       name="password"
                                                       type="password"
                                                       class="input"
                                                       data-type="password"
                                                       autocomplete="off"
                                                       placeholder="<?php echo $texts['passwd']; ?>:">
                                            </div>
                                            <?php
                                            echo form_error_format('password');
                                            if ($this->session->flashdata('flash_password'))
                                            {
                                                ?>
                                                <div class="alert alert-danger" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <?php echo $this->session->flashdata('flash_password'); ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="group">
                                                <!--label for="captcha" class="label"></label-->
                                                <input id="captcha"
                                                       name="captcha"
                                                       type="text"
                                                       class="input"
                                                       placeholder="<?php echo $texts['captcha']; ?>:">
                                                       <?php
                                                       echo form_error_format('captcha');
                                                       ?>
                                                <br>
                                                <div class="captcha-container" id="captcha_first">
                                                    <img id="captcha_img" src="<?php echo site_url(); ?>/captcha" alt="CAPTCHA Image" />
                                                    <a class="btn btn-lg btn-success pull-right" onclick="new_captcha()">
                                                        <span class="glyphicon glyphicon-refresh"></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="group">
                                                <input type="submit" class="btn btn-success btn-lg btn-login" value="Iniciar sesión">
                                            </div>
                                            <?php echo form_close(); ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="cores-help-modal">
                                <p>Necesita ayuda</p>
                                <p>Olvido su contraseña, <a onclick="recovery_password()">Solicitela aquí</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <!--div class="row div-logos">
                <div class="cores-logos">
                    <img src="<?php echo base_url(); ?>assets/tablero_tpl/img/ces.png" width="65px">
                    <img src="<?php echo base_url(); ?>assets/tablero_tpl/img/imss.png">
                </div>
            </div-->
            <!--div class="row cores-orbitas"></div-->
            <div id="" class="container">
                <div class="col-md-8">
                    <div id="cores-area-animation"></div>
                    <img src="<?php echo base_url(); ?>assets/login/report.jpg" class="img-responsive">
                </div>
                <div class="col-md-4 cores-column-info">
                    <div class="cores-info">
                        <div class="row">
                            <!--div><p><a class="cores-acceso" href="#" data-toggle="modal" data-target="#myModal">Acceso <i class="fa fa-bars" aria-hidden="true"></i></a></p></div-->
                        </div>
                        <div class="row cores-slider-text">
                            <div><p id="cores-banner">Decisiones basadas en información</p></div>
                        </div>
                        <div style="display: none;" class="row cores-help">
                            <div><p>Preguntas frecuentes <i class="fa fa-question-circle" aria-hidden="true"></i></p></div>
                        </div>
                    </div>
                </div>
                <!--address class=""><br>
                  <p style="text-align:center;"><b>Mesa de ayuda</b></p>
                  <p style="text-align:center; font-size:10px;">¿Tienes alguna duda? Comunícate con nosotros: </p>
                  <p style="text-align:center; font-size:10px;"><b>Teléfono:</b> 56 27 69 00 Ext. 21146, 21147 y 21148</p>
                  <p style="text-align:center; font-size:10px;"><b>Email:</b> soporte.cores@gmail.com &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</p>
                  <p style="text-align:center; font-size:10px;"><b>Horario:</b> de lunes a viernes, de 8h a 16h &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</p>
                </address-->
            </div>
        </div>

        <footer class="panel-footer" id="pie">
            <section id="f-header" class="container-fluid">
                <div class="container">
                    <div class="region region-separator3">
                        <section id="block-block-2" class="block block-block clearfix">
                            <div class="col-xs-12 col-sm-12 col-md-12" id="sn-title"><h4 style="text-align: center;">&nbsp;</h4></div>	
                        </section>
                    </div>
                </div>
            </section>
            <div class="container">
                <section id="f-CES" class="col-xs-12 col-sm-6 col-md-3">
                    <div class="region region-footer-t1">
                        <section id="block-block-41" class="block block-block clearfix">
                            <p><img alt="" src="http://educacionensalud.imss.gob.mx/?q=es/system/files/logofooter.png" style="width: 229px; height: 76px;"></p>
                        </section>
                    </div>
                </section>
                <section id="f-menu" class="col-xs-12 col-sm-6 col-md-3">
                    <div class="region region-footer-t2">
                        <section id="block-block-33" class="block block-block clearfix">
                            <p><span style="font-size:16px;"><span style="color:#ffffff;">Enlaces</span></span></p><p><span style="font-size:14px;"><a href="https://www.gob.mx/participa"><span style="color:#ffffff;">Participa</span></a><br><a href="https://www.gob.mx/publicaciones"><span style="color:#ffffff;">Publicaciones Oficiales</span></a><br><a href="http://www.ordenjuridico.gob.mx/"><span style="color:#ffffff;">Marco Jurídico</span></a><br><a href="https://consultapublicamx.inai.org.mx/vut-web/"><span style="color:#ffffff;">Plataforma Nacional de Transparencia</span></a></span></p>	</section>
                    </div>
                </section>
                <section id="f-contact" class="col-xs-12 col-sm-12 col-md-3">
                    <div class="fborder">
                        <div class="region region-footer-t3">
                            <section id="block-block-1" class="block block-block clearfix">
                                <div class="center-block block-contact withadress"><address class="faddress"><p><span style="color:#ffffff;"><span style="font-size:16px;">¿Qué es gob.mx?</span></span></p><p><span style="font-size:14px;"><span style="color:#ffffff;">Es el portal único de trámites, información y participación ciudadana.&nbsp;</span><ins><a href="https://www.gob.mx/que-es-gobmx"><span style="color:#ffffff;">Leer más</span></a></ins></span></p><p><span style="font-size:14px;"><a href="https://datos.gob.mx/"><span style="color:#ffffff;">Portal de datos abiertos</span></a></span></p><p><span style="font-size:14px;"><a href="https://www.gob.mx/accesibilidad"><span style="color:#ffffff;">Declaración de accesibilidad</span></a></span></p><p><span style="font-size:14px;"><a href="https://www.gob.mx/privacidadintegral"><span style="color:#ffffff;">Aviso de privacidad integral</span></a></span></p><p><span style="font-size:14px;"><a href="https://www.gob.mx/privacidadsimplificado"><span style="color:#ffffff;">Aviso de privacidad simplificado</span></a></span></p><p><span style="font-size:14px;"><a href="https://www.gob.mx/terminos"><span style="color:#ffffff;">Términos y condiciones</span></a></span></p><p><span style="font-size:14px;"><a href="https://www.gob.mx/terminos#medidas-seguridad-informacion"><span style="color:#ffffff;">Política de seguridad</span></a></span></p><p><span style="font-size:14px;"><a href="https://www.gob.mx/sitemap"><span style="color:#ffffff;">Mapa del sitio</span></a></span></p></address></div>	</section>
                        </div>
                    </div>
                </section>
                <section id="f-contact" class="col-xs-12 col-sm-12 col-md-3">
                    <div class="fborder">
                        <div class="region region-footer-t4">
                            <section id="block-block-42" class="block block-block clearfix">
                                <p><span style="color:#ffffff;"><span style="font-size:16px;">Otros trámites</span></span></p>
                                <p><span style="color:#ffffff;"><span style="font-size:14px;">Mesa de ayuda: dudas e información</span></span></p>
                                <p><span style="color:#ffffff;"><span style="font-size:14px;"><a href="mailto:gobmx@funcionpublica.gob.mx">gobmx@funcionpublica.gob.mx</a></span></span></p>
                                <p><span style="color:#ffffff;"><span style="font-size:14px;">Denuncia contra servidores públicos</span></span></p>
                                <p><span style="color:#ffffff;"><span style="font-size:14px;">Síguenos en:</span></span></p>
                                <p><span style="font-size:14px;"><br><a href="https://www.facebook.com/gobmexico/"><img alt="" src="http://educacionensalud.imss.gob.mx/?q=es/system/files/facebook.png" style="width: 24px; height: 24px;"></a><a href="https://twitter.com/GobiernoMX"><img alt="" src="http://educacionensalud.imss.gob.mx/?q=es/system/files/twitter.png" style="width: 24px; height: 24px;"></a></span></p>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
        </footer>

        <div class="cores-bottom text-center text-cores-bottom">Este sitio se visualiza correctamente apartir Mozila Firefox 50 y Google Chrome 55.</div>
        <script>
            /*document.getElementsByTagName("BODY")[0].onresize = function () {
                cores_animation()
            };

            var x = 0;
            function cores_animation() {
                //var txt = x += 1;
                //document.getElementById("demo").innerHTML = txt;
                cores_render_points2();
            }*/
<?php
if (isset($errores))
{
    ?>
                $('#myModal').modal({show: true});
    <?php
}

if (isset($user_recovery) || isset($code_recovery))
{
    ?>
                $('#modalRecovery').modal({show: true});
    <?php
}
?>
        </script>
    </body>
</html>
