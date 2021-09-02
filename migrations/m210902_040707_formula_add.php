<?php

use yii\db\Migration;

class m210902_040707_formula_add  extends Migration {

    public function safeUp() { 
        $this->execute('
            CREATE TABLE `d3product_unit_formula`(
            	`id` smallint(5) unsigned NOT NULL  auto_increment , 
            	`code` char(10) COLLATE latin1_swedish_ci NOT NULL  , 
            	`from_unit_id` smallint(3) unsigned NOT NULL  , 
            	`to_unit_id` smallint(3) unsigned NOT NULL  , 
            	`formula` text COLLATE latin1_swedish_ci NULL  , 
            	PRIMARY KEY (`id`) , 
            	UNIQUE KEY `code`(`code`) , 
            	KEY `d3product_unit_formula_ibfk_from_unit`(`from_unit_id`) , 
            	KEY `d3product_unit_formula_ibfk_to_unit`(`to_unit_id`) , 
            	CONSTRAINT `d3product_unit_formula_ibfk_from_unit` 
            	FOREIGN KEY (`from_unit_id`) REFERENCES `d3product_unit` (`id`) , 
            	CONSTRAINT `d3product_unit_formula_ibfk_to_unit` 
            	FOREIGN KEY (`to_unit_id`) REFERENCES `d3product_unit` (`id`) 
            ) ENGINE=InnoDB DEFAULT CHARSET=\'latin1\' COLLATE=\'latin1_swedish_ci\';        
        ');
    }

    public function safeDown() {
        echo "m210902_040707_formula_add cannot be reverted.\n";
        return false;
    }
}
