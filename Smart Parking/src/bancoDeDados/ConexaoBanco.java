package bancoDeDados;

import java.awt.HeadlessException;
import java.sql.*;     
import javax.swing.JOptionPane;  

/**
 * @author Smart Parking
 * @version 1.0
 */
public class ConexaoBanco {

    public Connection conexao;
    
    /**
     * Cria uma conexão com o banco de dados.
     * @throws ClassNotFoundException
     * @throws SQLException
     */
    public ConexaoBanco () throws ClassNotFoundException, SQLException{
        
        try{   
            String nomeDriver = "org.gjt.mm.mysql.Driver";     
            Class.forName(nomeDriver);     
    
            String nomeServidor = "192.185.176.97:3306/pipoc832_smartparking";         
            String url = "jdbc:mysql://" + nomeServidor;    
            String usuarioBanco = "pipoc832_admin";     
            String senha = "adm15281216";     
            conexao = DriverManager.getConnection(url, usuarioBanco, senha);          
        }
        catch (ClassNotFoundException | SQLException | HeadlessException e){
            JOptionPane.showMessageDialog(null,"Deu erro na conexão!! " + e.getMessage()); 
        }
        catch (Exception e){
            JOptionPane.showMessageDialog(null,"Deu erro!! " + e.getMessage()); 
        }
    }   
}