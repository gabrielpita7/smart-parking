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
    
            String nomeServidor = "31.170.166.57:3306/u842276689_bd";         
            String url = "jdbc:mysql://" + nomeServidor;    
            String usuarioBanco = "u842276689_adm2";     
            String senha = "ufba2014";     
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