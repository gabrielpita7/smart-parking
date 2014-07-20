<?php
    include('../includes/header_adm.php');
?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Painel Principal</h1>
                    <p>Olá, Seja Bem-vindo ao <strong>Sistema Web</strong> do SmartParking.</p>
                    <p> Para achar o que procura navegue no menu ao lado. </br> Se estiver com alguma dúvida, ou não achou o que procurava entre em contato com o nosso suporte técnico através
                    do e-mail: suporte@smartparking.com.br. </p> 
                    	
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="alert alert-warning">
            <?php  
                require_once("../models/user.php");    
                $codigoVaga = User::getCodigoVaga($_SESSION['user_id']);
                if($codigoVaga!=" "){
                    echo "<h4>Atualmente você está estacionado na vaga: <strong>".$codigoVaga."</strong></h4>";
                }else{
                    echo"Atualmente você não está estacionado";
                }
             ?>
            </div>

 <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          <i class="fa fa-bar-chart-o fa-fw"></i> Estacionamentos
                        </div>
                        <div class="panel-body">
                         
                         <?php                          
                              if(isset($_POST['campus'])){                        
                               
                                $opcao =mysql_real_escape_string ($_POST['campus']);
                                
                                if($opcao=="paf1") {
                                    header ("location: ../views/paf.php");
                                    exit();                                   
                                }
                                else {
                                    $_SESSION['mensagem'] = "Estacionamento em Manutenção!";
                                    header ("location: ../views/home.php");
                                    exit();
                                   
                                }
                                
                            }?>
                                
                        	<p><h4>Escolha abaixo o Campus (unidade) que deseja saber o status do estacionamento:</h4><p>
                            <div class="row">
                                <div class="col-lg-6">

                                 <?php 
                                    if(isset($_SESSION['mensagem'])){ ?>                           
                                       <div class="alert alert-danger">
                                           <?php echo $_SESSION['mensagem']?>
                                        </div> 
                                  <?php unset($_SESSION['mensagem']); } ?>

                                    <form role="form" method="post">
                                        <div class="form-group">
                                            <label>Campus</label>
                                            <select class="form-control" id="capus" name="campus">
                                                <option value="paf1">PAF I</option>
                                                <option value="politecnica">Politécnica</option>                               
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-default">Visualizar Status</button>
                                        <button type="reset" class="btn btn-default">Cancelar</button>
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                   
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
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