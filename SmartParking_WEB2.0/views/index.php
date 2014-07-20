<?php
    include('../includes/header.php');
?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Acessar - SmartParking UFBA</h3>
                    </div>
                    <div class="panel-body">
                    <?php                         
                      if($_SERVER['REQUEST_METHOD'] == 'POST'){                        
                        require_once("../models/user.php");
                        $senha =mysql_real_escape_string ($_POST['password']);
                        $user = mysql_real_escape_string ($_POST['username']);                        
                        $check = User::authenticate($user,$senha);
                        
                        if($check!=false) {
                            $session->login($check);
                            unset($_SESSION['wrong_login']);
                            if(isset($_POST["remember"])){
                                $usuario=$_POST["username"];
                                $tempo_expiracao= 3600; //uma hora
                                setcookie("lembrar", $usuario, $tempo_expiracao);
                            }
                            header ("location: ../views/home.php");
                            exit();
                            //echo"<meta http-equiv='refresh' content='0;URL=../view/adminHome'>";
                        }
                        else {
                            $_SESSION['mensagem'] = true;
                            header ("location: ../views/index.php");
                            exit();
                            //echo"<meta http-equiv='refresh' content='0;URL=../view/login.php?type=a01'>";
                        }
                        
                    }?>
                       <form id="loginForm" method="post" class="form-horizontal">
                       <?php 
                        if(isset($_SESSION['mensagem'])){ ?>                           
                           <div class="alert alert-danger">
                                Usuário e/ou senha inválidos
                            </div> 
                        <?php unset($_SESSION['mensagem']); } ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Login:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="username" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Senha:</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="password" />
                        </div>
                    </div>
                    <div class="form-group">                        
                            
                         <div class="col-lg-7 font-11">
                            <label class="col-lg-8 control-label">
                                <input name="remember" type="checkbox" value="Remember Me">Lembre-se
                            </label> 
                          </div>                                            
                        <div class="col-lg-5 font-12 control-label">
                          
                                <a href="esqueci-senha">Esqueci Minha Senha</a>
                             
                        </div>
                    </div>                                                                         
                    <div class="form-group">
                        <div class="col-md-5 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">Acessar</button>
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