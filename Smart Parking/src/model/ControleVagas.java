/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package model;

import usoGeral.Constantes;
import bancoDeDados.ConexaoBanco;
import java.io.File;
import java.sql.Date;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.SimpleDateFormat;
import java.util.LinkedList;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.ImageIcon;
import javax.swing.JOptionPane;
import net.sourceforge.barbecue.BarcodeFactory;
import net.sourceforge.barbecue.Barcode;
import net.sourceforge.barbecue.BarcodeException;
import net.sourceforge.barbecue.BarcodeImageHandler;

/**
 * @author Caveira
 * @version 
 */
public class ControleVagas {
    
    private static ConexaoBanco conexaoBanco;
    private static Statement statement;
    private static ResultSet result;
    
    public static void incrementaVaga (){
        ++Constantes.numeroVagasOcupadas;
    }
    
    public static void decrementaVaga (){
        --Constantes.numeroVagasOcupadas;
    }
    
    public static void incrementaVagaDeficiente (){
        ++Constantes.numeroVagasOcupadasDeficientes;
    }
    
    public static void decrementaVagaDeficiente (){
        --Constantes.numeroVagasOcupadasDeficientes;
    }
    
     /**
     * Grava código da vaga na tabela de usuários.
     * @return void
     */
    public void setCodigoVagaUsuarios (String codigoVaga){
        
        String update;
        
        try {
            conexaoBanco = new ConexaoBanco();
            statement = conexaoBanco.conexao.createStatement();
            update = "UPDATE usuarios SET CodigoVaga_Usuario = '" + codigoVaga + "' WHERE ID_Usuario = " + Constantes.idUsuario + " and CodigoAcesso_Usuario = " + Constantes.usuario.getCodigoMatricula();
            int updateStatement = statement.executeUpdate(update);
            if (updateStatement > 0){
                this.gravarHistorico(codigoVaga);
                this.gerarCodigoBarras(codigoVaga);
                this.exibirMensagem(codigoVaga);  
            }
            
        } catch (ClassNotFoundException | SQLException ex) {
            Logger.getLogger(ControleVagas.class.getName()).log(Level.SEVERE, null, ex);
            JOptionPane.showMessageDialog(null,"Erro no update do código da vaga. \n" + ex.getMessage());
        } catch (BarcodeException ex) {
            Logger.getLogger(ControleVagas.class.getName()).log(Level.SEVERE, null, ex);
        }
        finally{
            try {
                if (!statement.isClosed()){
                    statement.close();
                }
            } catch (SQLException ex) {
                Logger.getLogger(ControleVagas.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }
    
     /**
     * Remove vaga do usuário que está se retirando do estacionamento.
     * @return void
     */
    public void removerVaga(String codigoVaga){
        String update;
        
        try {
            conexaoBanco = new ConexaoBanco();
            statement = conexaoBanco.conexao.createStatement();
            update = "UPDATE usuarios SET CodigoVaga_Usuario = ' ' WHERE CodigoVaga_Usuario = '" + codigoVaga + "' and CodigoAcesso_Usuario = " + Constantes.usuario.getCodigoMatricula();
            int updateStatement = statement.executeUpdate(update);
            if (updateStatement > 0){
                this.gravarSaida(Constantes.usuarioAtivo, codigoVaga);
                
                if (Constantes.usuarioDeficiente){
                    ControleVagas.decrementaVagaDeficiente();
                }
                else{
                    ControleVagas.decrementaVaga();
                }
            }
            
        } catch (ClassNotFoundException | SQLException ex) {
            Logger.getLogger(ControleVagas.class.getName()).log(Level.SEVERE, null, ex);
            JOptionPane.showMessageDialog(null,"Erro ao remover vaga. \n" + ex.getMessage());
        }
        finally{
            try {
                if (!statement.isClosed()){
                    statement.close();
                }
            } catch (SQLException ex) {
                Logger.getLogger(ControleVagas.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }
    
     /**
     * Grava entrada de usuário na tabela de histórico.
     * @return void
     */
    private void gravarHistorico (String codigoVaga){
        String insert;
        
        Date data = new Date(System.currentTimeMillis());
        SimpleDateFormat dataAtual = new SimpleDateFormat("dd/MM/yyyy");
        SimpleDateFormat horaAtual = new SimpleDateFormat("HH:mm:ss");
        
        try {
            conexaoBanco = new ConexaoBanco();
            statement = conexaoBanco.conexao.createStatement();
            insert = "INSERT INTO estacionamento.historico(nomeUsuario_historico, codigoVaga_historico, data_historico, horario_entrada_historico) VALUES (";
            insert = insert + "'" + Constantes.usuarioAtivo + "', ";
            insert = insert + "'" + codigoVaga + "', ";
            insert = insert + "'" + dataAtual.format(data) + "', ";
            insert = insert + "'" + horaAtual.format(data) + "')";
            int updateStatement = statement.executeUpdate(insert);
            if (updateStatement > 0){

            }
        } catch (ClassNotFoundException | SQLException ex) {
            Logger.getLogger(ControleVagas.class.getName()).log(Level.SEVERE, null, ex);
            JOptionPane.showMessageDialog(null,"Erro ao gravar histórico. \n" + ex.getMessage());
        }
    }
    
    private void gravarSaida (String nomeUsuario, String codigoVaga){
        String update;
        
        Date data = new Date(System.currentTimeMillis());
        SimpleDateFormat dataAtual = new SimpleDateFormat("dd/MM/yyyy");
        SimpleDateFormat horaAtual = new SimpleDateFormat("HH:mm:ss");
        
        try {
            conexaoBanco = new ConexaoBanco();
            statement = conexaoBanco.conexao.createStatement();
            update = "UPDATE historico SET horario_saida_historico = '" + horaAtual.format(data) +"'";
            update = update + " WHERE nomeUsuario_historico = '" + nomeUsuario + "' ";
            update = update + " AND data_historico = '" + dataAtual.format(data) + "' ";
            update = update + " AND CodigoVaga_historico = '" + codigoVaga + "' ";
            int updateStatement = statement.executeUpdate(update);
            if (updateStatement > 0){

            }
        } catch (ClassNotFoundException | SQLException ex) {
            Logger.getLogger(ControleVagas.class.getName()).log(Level.SEVERE, null, ex);
            JOptionPane.showMessageDialog(null,"Erro ao gravar saída do histórico. \n" + ex.getMessage());
        }
    }
    
     /**
     * Verifica se o estacionamento possui vagas.
     * @return boolean
     */
    public static boolean verificaLotacaoEstacionamento(){
        int totalVagas = 0;
        int contadorUsuarios = 0;
        int usuariosDeficientes = 0;
        
        try {
            
            if (Constantes.usuarioDeficiente){
                totalVagas = Constantes.totalVagas;
            }
            else{
                totalVagas = Constantes.totalVagas - Constantes.totalVagasDeficientes;
            }
            
            conexaoBanco = new ConexaoBanco();
            statement = conexaoBanco.conexao.createStatement();
            result = statement.executeQuery("select * from usuarios");

            while (result.next()){
                if (!result.getString("CodigoVaga_Usuario").equals(" ")){
                    if (Constantes.usuarioDeficiente){
                        contadorUsuarios++;
                    }
                    else{
                        if (!((result.getString("CodigoVaga_Usuario").equals("0101")) || (result.getString("CodigoVaga_Usuario").equals("0102")))){
                            contadorUsuarios++;
                        }
                    }
                    
                    if (result.getString("Deficiente_Usuario").equals("S")){
                        usuariosDeficientes++;
                    }
                }
            }
        } catch (ClassNotFoundException | SQLException ex) {
            JOptionPane.showMessageDialog(null,"Problemas ao verificar lotação. " + ex.getMessage());
        }
        finally{
            try {
                if (!statement.isClosed()){
                    statement.close();
                }
            } catch (SQLException ex) {
                Logger.getLogger(ControleVagas.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        
        Constantes.numeroVagasOcupadas = contadorUsuarios;
        Constantes.numeroVagasOcupadasDeficientes = usuariosDeficientes;
        
        if (contadorUsuarios >= totalVagas){
            return false;
        }
        else{
            return true;
        }
    }
    
     /**
     * Gera código de barras referente a vaga.
     * @return void
     */
    public void gerarCodigoBarras(String codigoVaga) throws BarcodeException{

	Barcode codigoBarras = BarcodeFactory.createCode128B(codigoVaga);

        try {
            File arquivo = new File("codigoVaga" + codigoVaga + ".png");
            BarcodeImageHandler.savePNG(codigoBarras, arquivo);
        } catch (Exception  e) {
            JOptionPane.showMessageDialog(null,"Erro ao gerar código de barras.");
        }
    }
    
    public void exibirMensagem (String codigoVaga){
        String nomeArquivo = "codigoVaga" + codigoVaga + ".png";
        final ImageIcon codigoVagaPNG = new ImageIcon(nomeArquivo);
        JOptionPane.showMessageDialog(null,"Seja bem vindo(a): " + Constantes.usuarioAtivo,"Estacionamento", JOptionPane.INFORMATION_MESSAGE, codigoVagaPNG);
    }
    
     /**
     * Insere um usuário na fila de espera.
     * @return void
     */
    public void inserirNaFila (UsuarioEstacionamento usuario){
        try{
            if (ControleVagas.validaFila(usuario)){
                Constantes.filaEstacionamento.offer(usuario);
            }
            else{
                JOptionPane.showMessageDialog(null,"Esta usuário já se encontra na fila de espera.");
            }
        }
        catch (Exception e){
            JOptionPane.showMessageDialog(null,"Problemas ao inserir usuário na fila. " + e.getMessage());
        }
    }
    
     /**
     * Remove um usuário na fila de espera.
     * @return void
     */
    public void removerDaFila (){
        try{
            if (Constantes.filaEstacionamento.size() > 0){
                Constantes.filaEstacionamento.poll();
            }
        }
        catch (Exception e){
            JOptionPane.showMessageDialog(null,"Problemas ao remover usuário na fila. " + e.getMessage());
        }
    }
    
     /**
     * Validação da fila de espera.
     * @return boolean
     */
    public static boolean validaFila(UsuarioEstacionamento usuario){
        int i;
        
        try{
            for (i=0; i < Constantes.filaEstacionamento.size(); i++){
                if (Constantes.filaEstacionamento.get(i).getCodigoMatricula() == usuario.getCodigoMatricula()){
                    return false;
                }
            }
        }
        catch (Exception e){
            JOptionPane.showMessageDialog(null,"Problemas ao verificar usuário na fila. " + e.getMessage());
        }
        return true;
    }
    
}
