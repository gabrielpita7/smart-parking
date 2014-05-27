package model;
import iClasses.IUsuario;
import javax.swing.JOptionPane;

public abstract class Usuario implements IUsuario{
    
    private String nome;
    private boolean deficiente;
    private String senha;
    
    public void setNome (String nome){
        this.nome = nome;
    }
    
    public String getNome (){
        return this.nome;
    }
            
    public void setDeficiente(boolean deficiente){
        this.deficiente = deficiente;
    }
    
    public void setSenha(String senha){
        this.senha = senha;
    }
    
    public String getSenha(){
        return this.senha;
    }

    public boolean getDeficiente(){
        return this.deficiente;
    }

     /**
     * Valida usuário antes de o mesmo entrar no estacionamento.
     * @return boolean
     */
    public abstract boolean validarUsuario (UsuarioEstacionamento usuario, long matricula, String senha, String codigoVaga);
    
}
