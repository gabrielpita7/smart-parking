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

 <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          <i class="fa fa-bar-chart-o fa-fw"></i> Estacionamentos
                        </div>
                        <div class="panel-body">
                        	<p><h4>Escolha abaixo a unidade que deseja saber o status do estacionamento:</h4><p>
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form">
                                        <div class="form-group">
                                            <label>Unidade</label>
                                            <select class="form-control">
                                                <option>PAF I</option>
                                                <option>Politécnica</option>                               
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