<?php

use yii\db\Migration;

class m210902_040707_formula_add2  extends Migration {

    public function safeUp() { 
        $this->execute('
            CREATE TABLE `d3product_type_formula`(
            	`id` smallint(5) unsigned NOT NULL  auto_increment , 
            	`product_type_id` smallint(5) unsigned NOT NULL  , 
            	`unit_formula_id` smallint(5) unsigned NULL  , 
            	PRIMARY KEY (`id`) , 
            	KEY `d3propruduct_type_formula_ibfk_unit_formula`(`unit_formula_id`) , 
            	KEY `d3propruduct_type_formula_ibfk_product_type`(`product_type_id`) , 
            	CONSTRAINT `d3product_type_formula_ibfk_product_type` 
            	FOREIGN KEY (`product_type_id`) REFERENCES `d3product_product_type` (`id`) , 
            	CONSTRAINT `d3product_type_formula_ibfk_unit_formula` 
            	FOREIGN KEY (`unit_formula_id`) REFERENCES `d3product_unit_formula` (`id`) 
            ) ENGINE=InnoDB DEFAULT CHARSET=\'latin1\' COLLATE=\'latin1_swedish_ci\';        
        ');
    }

    public function safeDown() {
        echo "m210902_040707_formula_add2 cannot be reverted.\n";
        return false;
    }
}
