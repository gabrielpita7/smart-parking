<?php
    include('../includes/header_adm.php');
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#editForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            senhaAtual: {
                validators: {
                    notEmpty: {
                        message: 'A senha atual é obrigatória'
                    }
                }
            },
            senha1: {
                validators: {
                    notEmpty: {
                        message: 'A Senha é obrigatória'
                    }
                }
            },
            senha2: {
                validators: {
                    notEmpty: {
                        message: 'A repetição da Senha é obrigatória'
                    }
                }
            }
        }
    });
});
</script>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Editar Senha</h1>
                    <p>Nessa página você poderá alterar sua senha de acesso ao sistema web e ao sistema da portaria.</br> Caso deseje alterar informações de Nome e/ou Login entre em contato com seu colegiado.</p>
                    <p> Preencha o formulário abaixo e salve as informações para alterar sua senha. </br> Se estiver com alguma dúvida, ou não achou o que procurava entre em contato com o nosso suporte técnico através
                    do e-mail: suporte@smartparking.com.br. </p> 
                    	
                </div>
                <!-- /.col-lg-12 -->
            </div>

 <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          <i class="fa fa-pencil fa-fw"></i> Formulário de Edição
                        </div>
                        <div class="panel-body">                        	
                            <?php 
                            require_once("../models/user.php");                            
                            User::editUsuario($_SESSION['user_id']);?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php
    include('../includes/footer.php');
?>