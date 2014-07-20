<?php
    include('../includes/header.php');
?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Esqueci Minha Senha - SmartParking UFBA</h3>
                    </div>
                    <div class="panel-body">
                    <?php                         
                      if($_SERVER['REQUEST_METHOD'] == 'POST'){                        
                        require_once("../models/user.php");
                        $email = $_POST['email'];
						$login=mysql_real_escape_string ($_POST['login']);
                        $check = User::compareEmail($login,$email);
						
						if($check){
						
							$senha = User::getSenha($login);
							$nome = User::getName($login);																				
							// O remetente deve ser um e-mail do seu domínio conforme determina a RFC 822.
							// O return-path deve ser ser o mesmo e-mail do remetente.
							$headers = "MIME-Version: 1.1\r\n";
							$headers .= "Content-type: text/html; charset=utf-8\r\n";
							$headers .= "From: suporte@smartparking.com\r\n"; // remetente
							$headers .= "Return-Path: suporte@smartparking.com\r\n"; // return-path
							
							$text = '<h4>Recuperação de Senha</h4>';
							$text.= "<p>Olá,".$nome."</p>";
							$text.="</br>";
							$text.= "<p>Recebemos uma solicitação de recuperação de senha. Caso não tenha solicitado, desconsidere essa mensagem.</p>";
							$text.="Sua senha é:".$senha."";
							$text.="</br>";
							$text.="<p>Qualquer dúvida entre em contato consco.</p>";
							
							$envio = mail($email, "Recuperação de Senha", $text, $headers);
														
							if($envio){
							 $_SESSION['mensagem'] = "Sua Senha foi enviada com sucesso!";
							}else{
							 $_SESSION['mensagem2'] = "A Senha não pode ser enviada.";
							}
						}else{
							$_SESSION['mensagem2'] = "Login e/ou E-mail inválidos.";
						}
                        
                    }?>
                       <form id="senhaForm" method="post" class="form-horizontal">
                       <?php 
                        if(isset($_SESSION['mensagem'])){ ?>                           
                           <div class="alert alert-success">
                                <?php echo $_SESSION['mensagem']; 
								unset($_SESSION['mensagem2']);?>
                            </div> 
                        <?php unset($_SESSION['mensagem']); } ?>
                       
					   <?php 
                        if(isset($_SESSION['mensagem2'])){ ?>                           
                           <div class="alert alert-danger">
                                <?php echo $_SESSION['mensagem2']; ?>
                            </div> 
                        <?php unset($_SESSION['mensagem2']); } ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Login:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="login" placeholder="Digite seu login..."/>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-md-3 control-label">E-mail:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="email" placeholder="Digite seu email..."/>
                        </div>
                    </div>
                                                                                     
                    <div class="form-group">
                        <div class="col-md-5 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">Enviar Senha</button>
                        </div>
                    </div>
                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    include('../includes/footer.php');
?>