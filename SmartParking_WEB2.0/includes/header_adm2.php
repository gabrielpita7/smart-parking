<?php require_once("../models/session.php"); 
if(!$session->is_logged_in()){ 
    header ("location: ../views/index.php"); 
} 
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SmartParking UFBA</title>

    <!-- Core CSS - Include with every page -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/bootstrapValidator.min.css"/>
     <link rel="stylesheet" href="../css/style.css"/>

    <script type="text/javascript" src="../js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/bootstrapValidator.min.js"></script>

    <!-- SB Admin CSS - Include with every page -->
    <link href="../css/sb-admin.css" rel="stylesheet">

    <!-- Page-Level Plugin Scripts - Morris -->
    <script src="../js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="../js/plugins/morris/morris.js"></script>
    <link href="../css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
     <script src="../js/demo/morris-demo.js"></script>

    <script>
        $(document).ready(function() {
            $('#attributeForm').bootstrapValidator();
        });
    </script>

    <script>
$(document).ready(function() {
    $('#loginForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                validators: {
                    notEmpty: {
                        message: 'O Login é obrigatório'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'A Senha é obrigatória'
                    }
                }
            }
        }
    });
});
</script>
    
</head>

<body>

  <div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home">SmartParking UFBA</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <?php  
                    echo "Bem-Vindo, " ; echo $_SESSION['nome']; 
                ?>

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="../views/profile"><i class="fa fa-user fa-fw"></i> Perfil</a>
                        </li>
                        <li><a href="../views/user"><i class="fa fa-pencil fa-fw"></i> Editar Senha</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="../controllers/logout.php?cod=1"><i class="fa fa-sign-out fa-fw"></i> Sair</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li>
                            <a href="home"><i class="fa fa-dashboard fa-fw"></i> Painel Principal</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Estacionamentos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="paf">PAF I</a>
                                </li>
                                <li>
                                    <a href="#">Politécnica</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="../views/user"><i class="fa fa-pencil fa-fw"></i> Editar Senha</a>
                        </li>
                        <li>
                            <a href="../controllers/logout.php?cod=1"><i class="fa fa-sign-out fa-fw"></i> Sair</a>
                        </li>
                        
                    </ul>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>