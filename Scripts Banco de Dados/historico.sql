CREATE TABLE `historico` (
  `id_historico` int(8) NOT NULL AUTO_INCREMENT,
  `nomeUsuario_historico` varchar(50) DEFAULT NULL,
  `codigoVaga_historico` varchar(8) NOT NULL,
  `data_historico` varchar(11) DEFAULT NULL,
  `horario_entrada_historico` varchar(9) DEFAULT NULL,
  `horario_saida_historico` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`id_historico`,`codigoVaga_historico`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=latin1$$