<?php

session_start();

if(empty($_SESSION['cod_usuario'])){ echo "<script>location.href='./login.php';</script>";}

require_once "./config/ambiente.php";

require_once "./config/conexao.php";

require_once "include/ler_credencial.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company System</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Deltario Tecnologia">
    <meta name="author" content="KaijuThemes">

    <link href='http://fonts.googleapis.com/css?family=RobotoDraft:300,400,400italic,500,700' rel='stylesheet' type='text/css'>
    <link type="text/css" href="./assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet">          
	<link type="text/css" href="./assets/css/styles.css" rel="stylesheet">                                     <!-- Core CSS with all styles -->
    <link type="text/css" href="./assets/plugins/jstree/dist/themes/avenger/style.min.css" rel="stylesheet">    <!-- jsTree -->
    <link type="text/css" href="./assets/plugins/codeprettifier/prettify.css" rel="stylesheet">                <!-- Code Prettifier -->
    <link type="text/css" href="./assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">              <!-- iCheck -->
    <link type="text/css" href="./assets/plugins/form-daterangepicker/daterangepicker-bs3.css" rel="stylesheet">    <!-- DateRangePicker -->
    <link type="text/css" href="./assets/plugins/form-daterangepicker/daterangepicker-bs3.css" rel="stylesheet">    <!-- DateRangePicker -->
    <link type="text/css" href="./assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">                   <!-- Custom Checkboxes / iCheck -->
    <link type="text/css" href="./assets/plugins/clockface/css/clockface.css" rel="stylesheet">                       <!-- Clockface -->

    <script type="text/javascript" src="./assets/js/jquery-1.10.2.min.js"></script>                           <!-- Load jQuery -->
    <script type="text/javascript" src="./assets/js/jqueryui-1.9.2.min.js"></script>                             <!-- Load jQueryUI -->
    <script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>                              <!-- Load Bootstrap -->
    <script type="text/javascript" src="./assets/plugins/easypiechart/jquery.easypiechart.js"></script>      <!-- EasyPieChart-->
    <script type="text/javascript" src="./assets/plugins/sparklines/jquery.sparklines.min.js"></script>          <!-- Sparkline -->
    <script type="text/javascript" src="./assets/plugins/jstree/dist/jstree.min.js"></script>                <!-- jsTree -->
    <script type="text/javascript" src="./assets/plugins/codeprettifier/prettify.js"></script>               <!-- Code Prettifier  -->
    <script type="text/javascript" src="./assets/plugins/bootstrap-switch/bootstrap-switch.js"></script>         <!-- Swith/Toggle Button -->
    <script type="text/javascript" src="./assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>  <!-- Bootstrap Tabdrop -->
    <script type="text/javascript" src="./assets/plugins/iCheck/icheck.min.js"></script>                         <!-- iCheck -->
    <script type="text/javascript" src="./assets/js/enquire.min.js"></script>                                    <!-- Enquire for Responsiveness -->
    <script type="text/javascript" src="./assets/plugins/bootbox/bootbox.js"></script>                           <!-- Bootbox -->
    <script type="text/javascript" src="./assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script> <!-- nano scroller -->
    <script type="text/javascript" src="./assets/plugins/jquery-mousewheel/jquery.mousewheel.min.js"></script>   <!-- Mousewheel support needed for jScrollPane -->
    <script type="text/javascript" src="./assets/plugins/form-inputmask/jquery.inputmask.bundle.min.js"></script>     <!-- Input Masks Plugin -->
    <script type="text/javascript" src="./assets/demo/demo-mask.js"></script>
    <script type="text/javascript" src="./assets/js/application.js"></script>
    <script type="text/javascript" src="./assets/demo/demo.js"></script>
    <script type="text/javascript" src="./assets/demo/demo-switcher.js"></script>
    <script type="text/javascript" src="./assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js"></script>          <!-- Color Picker -->
    <script type="text/javascript" src="./assets/plugins/clockface/js/clockface.js"></script>                                     <!-- Clockface -->
    <script type="text/javascript" src="./assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>                  <!-- Datepicker -->
    <script type="text/javascript" src="./assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>                  <!-- Timepicker -->
    <script type="text/javascript" src="./assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>   <!-- DateTime Picker -->
    <script type="text/javascript" src="./assets/plugins/form-daterangepicker/moment.min.js"></script>                        <!-- Moment.js for Date Range Picker -->
    <script type="text/javascript" src="./assets/plugins/form-daterangepicker/daterangepicker.js"></script>                   <!-- Date Range Picker -->
    <script type="text/javascript" src="./assets/demo/demo-pickers.js"></script>

    
    </head>

    <body class="infobar-offcanvas">
        
        
        <header id="topnav" class="navbar navbar-midnightblue navbar-fixed-top clearfix" role="banner">

	<span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg">
		<a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar"><span class="icon-bg"><i class="fa fa-fw fa-bars"></i></span></a>
	</span>

	<ul class="nav navbar-nav toolbar pull-right">


        <li class="toolbar-icon-bg hidden-xs" id="trigger-fullscreen">
            <a href="#" class="toggle-fullscreen"><span class="icon-bg"><i class="fa fa-fw fa-arrows-alt"></i></span></i></a>
        </li>

		
		<li class="dropdown toolbar-icon-bg">
			<a href="#" class="dropdown-toggle" data-toggle='dropdown'><span class="icon-bg"><i class="fa fa-fw fa-user"></i></span></a>
			<ul class="dropdown-menu userinfo arrow">
                <li><a href="<?php echo sistema; ?>minha_conta.php"><span class="pull-left">Minha Conta</span> <i class="pull-right fa fa-user"></i></a></li>

                <?php if($_SESSION['usuario_conta'] != "1"){?>

                <li><a href="<?php echo sistema; ?>empresa/empresa_licenca_info.php?acao=ver_licenca"><span class="pull-left">Licença</span> <i class="pull-right fa fa-user"></i></a></li>

                <?php } ?>

				<li class="divider"></li>
				<li><a href="<?php echo sistema; ?>logout.php"><span class="pull-left">Sair</span> <i class="pull-right fa fa-sign-out"></i></a></li>
			</ul>
		</li>

	</ul>

</header>

<div id="wrapper">

    <div id="layout-static">

        <?php include('./'.MontaMenu());?>