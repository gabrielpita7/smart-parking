CREATE TABLE `usuarios` (
  `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT,
  `Nome_Usuario` varchar(50) DEFAULT NULL,
  `CPF_Usuario` varchar(18) DEFAULT NULL,
  `CodigoAcesso_Usuario` int(9) NOT NULL COMMENT 'Pode ser o código de matrícula ou o código de acesso de um funcionário.',
  `Deficiente_Usuario` varchar(1) DEFAULT NULL COMMENT 'Diz se o usuário é portador de deficiência S/N).',
  `Tipo_Usuario` varchar(1) DEFAULT NULL COMMENT 'F-Funcionário e E-Estudante',
  `Cargo_Usuario` varchar(40) DEFAULT NULL COMMENT 'Cargo ou curso do usuário.',
  `Senha_Usuario` varchar(6) DEFAULT NULL,
  `CodigoVaga_Usuario` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`ID_Usuario`,`CodigoAcesso_Usuario`),
  UNIQUE KEY `CodigoAcesso_Usuario_UNIQUE` (`CodigoAcesso_Usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COMMENT='Tabela contendo os dados dos usuárioa do estacionamento.'$$
