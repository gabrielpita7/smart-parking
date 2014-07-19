/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

import model.ControleVagas;
import model.UsuarioEstacionamento;
import org.junit.Test;
import static org.junit.Assert.*;

/**
 * @author Smart-Parking
 * @version 1.0
 */
public class TesteValidadores {

     @Test
    public void testeLoginUsuario() {         
         UsuarioEstacionamento usuario = new UsuarioEstacionamento("Miguelino", true,0022220, true, "12312");
         boolean teste = usuario.validarUsuario(usuario, 0022220, "12312", " ");
         assertNotNull("Usuario Vazio",usuario);
         assertTrue("Usuario Não Existe", teste);
     }
     
     @Test
     public void testeValidaVagas(){    
         ControleVagas controleVagas = new ControleVagas();
         boolean teste = ControleVagas.verificaLotacaoEstacionamento();
         assertNotNull("Não foi possível instanciar a classe.",controleVagas);
         assertTrue("Estacionamento lotado.", teste);
     }
     
     @Test
     public void testeValidaFila(){    
         ControleVagas controleVagas = new ControleVagas();
         UsuarioEstacionamento usuario = new UsuarioEstacionamento("Miguelino", true,0022220, true, "12312");
         boolean teste = ControleVagas.validaFila(usuario);
         assertNotNull("Não foi possível instanciar a classe.",controleVagas);
         assertNotNull("Usuário não cadastrado.",usuario);
         assertTrue("Estacionamento lotado.", teste);
     }
}