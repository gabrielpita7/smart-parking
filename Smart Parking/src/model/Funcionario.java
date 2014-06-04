package model;

public class Funcionario extends Usuario{
    private long codigoFuncionario;
    private boolean estudanteAtivo;
    
    public Funcionario (String nome, boolean deficiente, long codigoFuncionario, boolean estudanteAtivo){
        this.setNome(nome);
        this.setDeficiente(deficiente);
        this.codigoFuncionario = codigoFuncionario;
        this.estudanteAtivo = estudanteAtivo;
    }
    
    public Funcionario (long codigoMatricula){
        // Aqui pega o codigo de matricula, pesquisa no banco e carrega as informacoes
    }

    @Override
    public boolean validarUsuario(UsuarioEstacionamento usuario, long matricula, String senha, String codigoVaga) {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }
}
