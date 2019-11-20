<?php

session_start();
if(empty($_SESSION['usuario_id'])){ echo "<script>location.href='login.php';</script>";}
require_once "../config/ambiente.php";

require_once "../config/conexao.php";

require_once "ler_credencial.php";

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
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,400italic,600,700' rel='stylesheet' type='text/css'>

    <link type="text/css" href="../assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet">        <!-- Font Awesome -->
    
	<link type="text/css" href="../assets/css/styles.css" rel="stylesheet">                                     <!-- Core CSS with all styles -->

    <link type="text/css" href="../assets/plugins/jstree/dist/themes/avenger/style.min.css" rel="stylesheet">    <!-- jsTree -->
    <link type="text/css" href="../assets/plugins/codeprettifier/prettify.css" rel="stylesheet">                <!-- Code Prettifier -->
    <link type="text/css" href="../assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">              <!-- iCheck -->
    <link type="text/css" href="../assets/plugins/form-daterangepicker/daterangepicker-bs3.css" rel="stylesheet">    <!-- DateRangePicker -->

    <link type="text/css" href="../assets/plugins/form-daterangepicker/daterangepicker-bs3.css" rel="stylesheet">    <!-- DateRangePicker -->
    <link type="text/css" href="../assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">                   <!-- Custom Checkboxes / iCheck -->
    <link type="text/css" href="../assets/plugins/clockface/css/clockface.css" rel="stylesheet">                       <!-- Clockface -->

    <script type="text/javascript" src="../assets/js/jquery-1.10.2.min.js"></script>                           <!-- Load jQuery -->
    
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
                <li><a href="<?php echo sistema; ?>/minha_conta.php"><span class="pull-left">Minha Conta</span> <i class="pull-right fa fa-user"></i></a></li>
                
                <?php if($_SESSION['usuario_conta'] != "1"){?>

                <li><a href="<?php echo sistema; ?>empresa/empresa_licenca_info.php?acao=ver_licenca"><span class="pull-left">Licença</span> <i class="pull-right fa fa-user"></i></a></li>

                <?php } ?>

				<li class="divider"></li>

                <li><a href="<?php echo sistema; ?>/logout.php"><span class="pull-left">Sair</span> <i class="pull-right fa fa-sign-out"></i></a></li>
                
			</ul>
		</li>

	</ul>

</header>

<div id="wrapper">

    <div id="layout-static">

        <?php 
            include('../menu.php');
        ?>