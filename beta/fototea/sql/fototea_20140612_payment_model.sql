-- -----------------------------------------------------
-- Table `product`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `product` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `order`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `order` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` VARCHAR(45) NOT NULL ,
  `status` ENUM('Completed') NOT NULL ,
  `date` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `order_product`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `order_product` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `subtotal` FLOAT NOT NULL ,
  `tax` FLOAT NULL ,
  `id_project` INT NULL ,
  `order_id` INT NOT NULL ,
  `product_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_order_product_order_idx` (`order_id` ASC) ,
  INDEX `fk_order_product_product1_idx` (`product_id` ASC) ,
  CONSTRAINT `fk_order_product_order`
    FOREIGN KEY (`order_id` )
    REFERENCES `order` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_product_product1`
    FOREIGN KEY (`product_id` )
    REFERENCES `product` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `payment`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `payment` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `type` ENUM('PuntoPagos','Deposit','Transfer') NOT NULL ,
  `date` DATETIME NOT NULL ,
  `status` ENUM('Approved','Rejected','Pending') NOT NULL ,
  `gateway_id` INT NULL ,
  `order_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_payment_order1_idx` (`order_id` ASC) ,
  CONSTRAINT `fk_payment_order1`
    FOREIGN KEY (`order_id` )
    REFERENCES `order` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
