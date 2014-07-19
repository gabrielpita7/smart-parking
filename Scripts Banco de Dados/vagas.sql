CREATE  TABLE `estacionamento`.`vagas` (
  `ID_Vagas` INT(2) NOT NULL AUTO_INCREMENT ,
  `Total_Vagas` INT(6) NULL ,
  `Largura_Vagas` INT(3) NULL ,
  `Altura_Vagas` INT(3) NULL ,
  `Total_Preferencial_Vagas` INT(4) NULL ,
  PRIMARY KEY (`ID_Vagas`) ,
  UNIQUE INDEX `ID_vagas_UNIQUE` (`ID_Vagas` ASC) );