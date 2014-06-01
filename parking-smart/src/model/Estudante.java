package model;

public class Estudante extends Usuario{
    
    private long codigoMatricula;
    private boolean estudanteAtivo;
    
    public Estudante (String nome, boolean deficiente, long codigoMatricula, boolean estudanteAtivo){
        this.setNome(nome);
        this.setDeficiente(deficiente);
        this.codigoMatricula = codigoMatricula;
        this.estudanteAtivo = estudanteAtivo;
    }
    
    public Estudante (long codigoMatricula){
        // Aqui pega o codigo de matricula, pesquisa no banco e carrega as informacoes
    }
    
    public long getCodigoMatricula (){
        return this.codigoMatricula;
    }
    
    public boolean getEstudanteAtivo (){
        return this.estudanteAtivo;
    }

    @Override
    public boolean validarUsuario(UsuarioEstacionamento usuario, long matricula, String senha, String codigoVaga) {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }
    
}
