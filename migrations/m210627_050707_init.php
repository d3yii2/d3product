<?php

use yii\db\Migration;

class m210627_050707_init extends Migration
{

    public function safeUp()
    {
        $this->execute('
            CREATE TABLE `d3product_group` (
              `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
              `sys_company_id` smallint(5) unsigned NOT NULL,
              `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;                    
        ');

        $this->execute('
            CREATE TABLE `d3product_input_type` (
              `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
              `sys_company_id` smallint(5) unsigned DEFAULT NULL,
              `name` char(30) CHARACTER SET utf8 DEFAULT NULL,
              `input_class` varchar(255) DEFAULT NULL,
              `data` text CHARACTER SET utf8,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;        
        ');
        $this->execute('
            CREATE TABLE `d3product_unit` (
              `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
              `sys_company_id` smallint(5) unsigned DEFAULT NULL,
              `code` char(20) DEFAULT NULL COMMENT \'Code\',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;        
        ');
        $this->execute('
            CREATE TABLE `d3product_product_type` (
              `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
              `sys_company_id` smallint(5) unsigned NOT NULL,
              `name` varchar(250) CHARACTER SET utf8 DEFAULT NULL COMMENT \'Name\',
              `unit_id` smallint(3) unsigned DEFAULT NULL COMMENT \'Unit\',
              `template` varchar(250) CHARACTER SET utf8 DEFAULT NULL COMMENT \'Template\',
              PRIMARY KEY (`id`),
              KEY `product3_product_type_ibfk_unit` (`unit_id`),
              CONSTRAINT `d3product_product_type_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `d3product_unit` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;        
        ');
        $this->execute('
            CREATE TABLE `d3product_product_type_group` (
              `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
              `product_type_id` smallint(5) unsigned NOT NULL COMMENT \'Product Type\',
              `group_id` smallint(5) unsigned NOT NULL COMMENT \'Group\',
              PRIMARY KEY (`id`),
              KEY `product3_product_type_group_ibfk_product_type` (`product_type_id`),
              KEY `product3_product_type_group_ibfk_group` (`group_id`),
              CONSTRAINT `d3product_product_type_group_ibfk_group` FOREIGN KEY (`group_id`) REFERENCES `d3product_group` (`id`),
              CONSTRAINT `d3product_product_type_group_ibfk_product_type` FOREIGN KEY (`product_type_id`) REFERENCES `d3product_product_type` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;        
        ');
        $this->execute('
            CREATE TABLE `d3product_product` (
              `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
              `sys_company_id` smallint(5) unsigned NOT NULL,
              `name` varchar(256) CHARACTER SET utf8 DEFAULT NULL COMMENT \'Name\',
              `description` text CHARACTER SET utf8 COMMENT \'Description\',
              `unit_id` smallint(3) unsigned DEFAULT NULL COMMENT \'Unit\',
              `product_type_id` smallint(5) unsigned DEFAULT NULL COMMENT \'Type\',
              PRIMARY KEY (`id`),
              KEY `product3_product_ibfk_product_type` (`product_type_id`),
              KEY `product3_product_ibfk_unit` (`unit_id`),
              CONSTRAINT `d3product_product_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `d3product_unit` (`id`),
              CONSTRAINT `d3product_product_ibfk_product_type` FOREIGN KEY (`product_type_id`) REFERENCES `d3product_product_type` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        
        ');
        $this->execute('
            CREATE TABLE `d3product_product_group` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `product_id` smallint(5) unsigned NOT NULL COMMENT \'Product\',
              `group_id` smallint(3) unsigned NOT NULL COMMENT \'Type\',
              PRIMARY KEY (`id`),
              KEY `product3_product_group_ibfk_product` (`product_id`),
              KEY `product3_product_group_ibfk_group` (`group_id`),
              CONSTRAINT `d3product_product_group_ibfk_group` FOREIGN KEY (`group_id`) REFERENCES `d3product_group` (`id`),
              CONSTRAINT `d3product_product_group_ibfk_product` FOREIGN KEY (`product_id`) REFERENCES `d3product_product` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        
        ');
        $this->execute('
            CREATE TABLE `d3product_type_attributes` (
              `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
              `product_type_id` smallint(5) unsigned DEFAULT NULL COMMENT \'Product Type\',
              `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT \'Attribute Name\',
              `input_type_id` tinyint(5) unsigned NOT NULL COMMENT \'Input Type\',
              `unit_id` smallint(5) unsigned DEFAULT NULL COMMENT \'Unit\',
              PRIMARY KEY (`id`),
              KEY `product3_type_attributes_ibfk_input_type` (`input_type_id`),
              KEY `product3_type_attributes_ibfk_product_type` (`product_type_id`),
              KEY `unit_id` (`unit_id`),
              CONSTRAINT `d3product_type_attributes_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `d3product_unit` (`id`),
              CONSTRAINT `d3product_type_attributes_ibfk_input_type` FOREIGN KEY (`input_type_id`) REFERENCES `d3product_input_type` (`id`),
              CONSTRAINT `d3product_type_attributes_ibfk_product_type` FOREIGN KEY (`product_type_id`) REFERENCES `d3product_product_type` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
        
        ');
        $this->execute('
            CREATE TABLE `d3product_attributes` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `product_id` smallint(5) unsigned NOT NULL COMMENT \'Product\',
              `type_attribute_id` smallint(5) unsigned DEFAULT NULL COMMENT \'Product Type\',
              `name` varchar(250) DEFAULT NULL COMMENT \'Name\',
              `input_type_id` tinyint(3) unsigned NOT NULL COMMENT \'Input Type\',
              `unit_id` smallint(5) unsigned DEFAULT NULL COMMENT \'Unit\',
              `value` varchar(50) DEFAULT NULL COMMENT \'Value\',
              PRIMARY KEY (`id`),
              KEY `product3_attributes_ibfk_product` (`product_id`),
              KEY `product3_attributes_ibfk_type_attribute` (`type_attribute_id`),
              KEY `unit_id` (`unit_id`),
              KEY `input_type_id` (`input_type_id`),
              CONSTRAINT `d3product_attributes_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `d3product_unit` (`id`),
              CONSTRAINT `d3product_attributes_ibfk_2` FOREIGN KEY (`input_type_id`) REFERENCES `d3product_input_type` (`id`),
              CONSTRAINT `d3product_attributes_ibfk_product` FOREIGN KEY (`product_id`) REFERENCES `d3product_product` (`id`),
              CONSTRAINT `d3product_attributes_ibfk_type_attribute` FOREIGN KEY (`type_attribute_id`) REFERENCES `d3product_type_attributes` (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;
        
        ');
    }

    public function safeDown()
    {
        echo "m210627_050707_init cannot be reverted.\n";
        return false;
    }
}
