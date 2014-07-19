/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package interfacesUsuario;

import java.awt.Desktop;
import executor.LoginUsuario;
import java.awt.Color;
import java.awt.Component;
import java.awt.Dimension;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.ImageIcon;
import java.io.FileOutputStream;
import java.io.OutputStream;
import com.itextpdf.text.Document;
import com.itextpdf.text.Element;
import com.itextpdf.text.Image;
import com.itextpdf.text.PageSize;
import com.itextpdf.text.Paragraph;
import com.itextpdf.text.pdf.PdfPCell;
import com.itextpdf.text.pdf.PdfPTable;
import com.itextpdf.text.pdf.PdfWriter;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.table.TableCellRenderer;
import bancoDeDados.ConexaoBanco;
import com.itextpdf.text.DocumentException;
import java.io.File;
import java.io.IOException;
import usoGeral.Constantes;
import model.ControleVagas;

/**
 * @author Smart Parking
 * @version 1.0
 */

public class Estacionamento extends JPanel {

    JTable gridVagas;
    JFrame frame;
    int count = 23;
    ControleVagas vagas;
    private ConexaoBanco conexaoBanco;
    private Statement statement;
    private ResultSet result;

    public Estacionamento() {
        
        int preferenciais, i, j;
        
        this.buscarDimensoes();
        
        String[] columns = new String[Constantes.vagasHorizontais];
        String[][] data = new String[Constantes.vagasVerticais][Constantes.vagasHorizontais];
        
        preferenciais = Constantes.vagasPreferenciais;
        
        for (i = 0; i < Constantes.vagasHorizontais; i++){
            columns[i] = "SETOR " + i;
        }
        
        for (j = 0; j < Constantes.vagasHorizontais; j++){
            for (i = 0; i < Constantes.vagasVerticais; i++){
                if (preferenciais > 0) {
                    data[i][j] = "PREFERENCIAL";
                    preferenciais--;
                }
                else{
                    data[i][j] = "DISPONIVEL";
                }
            }
        }
                
        //String[] columns = {"SETOR 1", "SETOR 2", "SETOR 3"};

        /*String[][] data = {{"PREFERENCIAL", "PREFERENCIAL", "DISPONIVEL"},
            {"DISPONIVEL", "DISPONIVEL", "DISPONIVEL"},
            {"DISPONIVEL", "DISPONIVEL", "DISPONIVEL"}};*/

        gridVagas = new JTable(data, columns) {
            public boolean isCellEditable(int data, int columns) {
                return false;
            }

            public Component prepareRenderer(TableCellRenderer r, int data, int columns) {
                JLabel label = (JLabel) super.prepareRenderer(r, data, columns);

                if ("INDISPONIVEL".equals(gridVagas.getValueAt(data, columns).toString())) {
                    label.setBackground(Color.RED);
                } else {
                    label.setBackground(Color.GREEN);
                }
                if ("PREFERENCIAL".equals(gridVagas.getValueAt(data, columns).toString())) {
                    label.setBackground(Color.YELLOW);
                }

                return label;
            }
        };

        gridVagas.setPreferredScrollableViewportSize(new Dimension(450, 144)); //63 - 142
        gridVagas.setFillsViewportHeight(true);

        JScrollPane jps = new JScrollPane(gridVagas);
        add(jps);

        gridVagas.addMouseListener(new MouseAdapter() {
            public void mouseClicked(MouseEvent e){
                int linha, coluna;
                String linhaFormat, colunaFormat;
                String retorno;

                linha = gridVagas.getSelectedRow();
                coluna = gridVagas.getSelectedColumn();
                linhaFormat = Constantes.formatarCodigoVaga(2, "0" + Integer.toString(linha + 1));
                colunaFormat = Constantes.formatarCodigoVaga(2, "0" + Integer.toString(coluna + 1));
                
                if (Constantes.adminAtivo){
                    buscarHistorico(linhaFormat + colunaFormat);
                    Administracao administacao = new Administracao();
                    administacao.show();
                    frame.dispose();
                }
                else{
                    if ("INDISPONIVEL".equals(gridVagas.getValueAt(linha, coluna).toString())){
                        JOptionPane.showMessageDialog(null, "Vaga já preenchida!");
                    }
                    else{
                        if (Constantes.usuarioDeficiente){
                            estacionar(linhaFormat + colunaFormat);
                        }
                        else{
                            if ("PREFERENCIAL".equals(gridVagas.getValueAt(linha, coluna).toString())){
                                JOptionPane.showMessageDialog(null, "Vaga reservada para deficientes. Favor escolher outra vaga!");
                            }
                            else{
                                estacionar(linhaFormat + colunaFormat);
                            }
                        }
                    }
                }
            }
        });
        
        if (Constantes.adminAtivo){
            frame = new JFrame("Histórico de vagas");
        }
        else{
            frame = new JFrame("Escolha sua vaga");
        }
      
        frame.setSize(166 * Constantes.vagasHorizontais, 18 * Constantes.vagasVerticais);
        frame.setVisible(true);
        frame.setLocationRelativeTo(null);
        frame.setResizable(false);
        frame.setDefaultCloseOperation(JFrame.DO_NOTHING_ON_CLOSE);
        frame.add(this.gridVagas);
        
        this.preencherVagasResiduais();
    }
    
     /**
     * Buscar histórico de vaga e gerar pdf.
     * @return void
     */
    private void buscarHistorico(String codigoVaga){
        Document documento = null;
        OutputStream arquivo = null;
        String nomeArquivo = "";
		
        try {
            //cria o documento tamanho A4, margens de 2,54cm
            documento = new Document(PageSize.A4, 72, 72, 72, 72);
			
            //cria a stream de saída
            nomeArquivo = "historico" + codigoVaga + ".pdf";
            arquivo = new FileOutputStream(nomeArquivo);
			
            //associa a stream de saída ao 
            PdfWriter.getInstance(documento, arquivo);
			
            //abre o documento
            documento.open();

            //adiciona o texto ao PDF
            Paragraph p = new Paragraph("Vaga: " + codigoVaga);
            documento.add(p);
            
            Image img = Image.getInstance("ufbalogo.png");
            img.setAlignment(Element.ALIGN_CENTER);
            documento.add(img);
            p.setSpacingAfter(150);
            p = new Paragraph("Estacionamento - Universidade Federal da Bahia");
            p.setAlignment(Element.ALIGN_CENTER);
            documento.add(p);
            p = new Paragraph("\n");
            documento.add(p);
            p = new Paragraph("\n");
            documento.add(p);
 
            conexaoBanco = new ConexaoBanco();
            statement = conexaoBanco.conexao.createStatement();
            result = statement.executeQuery("select * from historico where codigoVaga_historico = '" + codigoVaga + "'");
            
            PdfPTable table = new PdfPTable(4);
            PdfPCell header = new PdfPCell(new Paragraph("Histórico de Vaga"));
            header.setColspan(4);
            table.addCell(header);
            
            table.addCell("             Nome");
            table.addCell("    Data de Entrada");
            table.addCell("  Horário de Entrada");
            table.addCell("  Horário de Saída");
            
            while (result.next()){
                table.addCell(result.getString("nomeUsuario_historico"));
                table.addCell(result.getString("data_historico"));
                table.addCell(result.getString("horario_entrada_historico"));
                table.addCell(result.getString("horario_saida_historico"));
            }
            
            documento.add(table); 
            
        } 
        catch (DocumentException | IOException e){
            JOptionPane.showMessageDialog(null,"Ocoreu um problema na geração do histórico. " + e.getMessage());
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(Estacionamento.class.getName()).log(Level.SEVERE, null, ex);
        } catch (SQLException ex) {
            Logger.getLogger(Estacionamento.class.getName()).log(Level.SEVERE, null, ex);
        }
        finally {
            try{
                if (documento != null) {
                    //fechamento do documento
                    documento.close();
                }
                if (arquivo != null) {
                   //fechamento da stream de saída
                   arquivo.close();
                }
                
                if (statement.isClosed()){
                    statement.close();
                }
                
                try {  
                    File arquivoHistorico = new File(nomeArquivo); 
                    Desktop.getDesktop().open(arquivoHistorico);
                } catch(Exception e) {   
                  JOptionPane.showMessageDialog(null, "Problemas ao abrir arquivo. " + e.getMessage());  
                } 
    
            }
            catch (IOException e){
                JOptionPane.showMessageDialog(null,"Erro ao fechar arquivo.");
            } catch (SQLException ex) {
                Logger.getLogger(Estacionamento.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }
    
     /**
     * Insere um usuário no estacionamento.
     * @return void
     */
    private void estacionar(String codigoVaga){
        vagas = new ControleVagas();
        
        if (Constantes.usuarioDeficiente){
            ControleVagas.incrementaVagaDeficiente();
        }
        else{
            ControleVagas.incrementaVaga();
        }
     
        vagas.setCodigoVagaUsuarios(codigoVaga);
        LoginUsuario login = new LoginUsuario();
        login.show();
        frame.dispose();  
    }
    
    private void preencherVagasResiduais (){
        int linha, coluna;
        try {
            conexaoBanco = new ConexaoBanco();
            statement = conexaoBanco.conexao.createStatement();
            result = statement.executeQuery("select * from usuarios");
        } catch (ClassNotFoundException | SQLException ex) {
            Logger.getLogger(LoginUsuario.class.getName()).log(Level.SEVERE, null, ex);
        }
        try {
            while (result.next()){
                if (!" ".equals(result.getString("CodigoVaga_Usuario"))){
                    linha = Integer.parseInt(result.getString("CodigoVaga_Usuario").substring(0, 2)) - 1;
                    coluna = Integer.parseInt(result.getString("CodigoVaga_Usuario").substring(2, 4)) - 1;
                    gridVagas.setValueAt("INDISPONIVEL", linha, coluna);
                }
            }
        } catch (SQLException ex) {
            Logger.getLogger(LoginUsuario.class.getName()).log(Level.SEVERE, null, ex);
        }
        catch (Exception e){
            JOptionPane.showMessageDialog(null,"Ocoreu um problema no método preencherVagasResiduais. " + e.getMessage());
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

    private void buscarDimensoes () {
        try {
            conexaoBanco = new ConexaoBanco();
            statement = conexaoBanco.conexao.createStatement();
            result = statement.executeQuery("select * from vagas where ID_Vagas = 1");
        } catch (ClassNotFoundException | SQLException ex) {
            Logger.getLogger(LoginUsuario.class.getName()).log(Level.SEVERE, null, ex);
        }
        try {
            while (result.next()){
                Constantes.vagasHorizontais = Integer.parseInt(result.getString("Largura_Vagas"));
                Constantes.vagasVerticais = Integer.parseInt(result.getString("Altura_Vagas"));
                Constantes.vagasPreferenciais = Integer.parseInt(result.getString("Total_Preferencial_Vagas"));
            }
        } catch (SQLException ex) {
            Logger.getLogger(LoginUsuario.class.getName()).log(Level.SEVERE, null, ex);
        }
        catch (Exception e){
            JOptionPane.showMessageDialog(null,"Ocoreu um problema no método preencherVagasResiduais. " + e.getMessage());
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
}