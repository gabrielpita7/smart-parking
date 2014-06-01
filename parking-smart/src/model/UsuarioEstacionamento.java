package model;

import bancoDeDados.ConexaoBanco;
import javax.swing.JOptionPane;
import usoGeral.Constantes;

public class UsuarioEstacionamento extends Usuario{
    
    private long codigoMatricula;
    private boolean estudanteAtivo;
    private ConexaoBanco Banco;
    
    public UsuarioEstacionamento (String nome, boolean deficiente, long codigoMatricula, boolean estudanteAtivo, String senha){
        this.setNome(nome);
        this.setDeficiente(deficiente);
        this.setSenha(senha);
        this.codigoMatricula = codigoMatricula;
        this.estudanteAtivo = estudanteAtivo;
    }
    
    public long getCodigoMatricula (){
        return this.codigoMatricula;
    }
    
    public boolean getEstudanteAtivo (){
        return this.estudanteAtivo;
    }
    
    public boolean validarUsuario (UsuarioEstacionamento usuario, long matricula, String senha, String codigoVaga){
        try{
            if (!codigoVaga.equals(" ")){
                String retorno = JOptionPane.showInputDialog(null,"Informe o código de barras!");
                ControleVagas controleVagas = new ControleVagas();
                controleVagas.removerVaga(retorno);
                if (Constantes.filaEstacionamento.size() > 0){
                    JOptionPane.showMessageDialog(null,"O usuário de código: " + Constantes.filaEstacionamento.get(0).getCodigoMatricula() + " Recebeu um SMS informando a vaga disponível.");
                }
                controleVagas.removerDaFila();
                return false;
            }
            else if (usuario.getCodigoMatricula()!= matricula) {
                JOptionPane.showMessageDialog(null,"Usuário não cadastrado!");
                return false;
            }
            else{
                if (!senha.equals(usuario.getSenha())){
                    JOptionPane.showMessageDialog(null,"Usuário e senha não compatíveis!");
                    return false;
                }
            }
        }catch (Exception e){
            JOptionPane.showMessageDialog(null,"Erro function validarUsuario. " + e.getMessage());
        }
        return true;
    }
}
