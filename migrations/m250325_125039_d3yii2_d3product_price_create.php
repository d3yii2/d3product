<?php

use yii\db\Migration;

class m250325_125039_d3yii2_d3product_price_create  extends Migration {

    public function safeUp() { 
        $this->execute('
            CREATE TABLE `d3product_price` (
              `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
              `product_id` SMALLINT UNSIGNED NOT NULL COMMENT \'Product\',
              `price` DECIMAL (10, 2) UNSIGNED NOT NULL COMMENT \'Price\',
              `notes` TEXT CHARSET utf8 COMMENT \'Notes\',
              PRIMARY KEY (`id`),
              FOREIGN KEY (`product_id`) REFERENCES `d3product_product` (`id`)
            );
            
                    
        ');
    }

    public function safeDown() {
        echo "m250325_125039_d3yii2_d3product_price_create cannot be reverted.\n";
        return false;
    }
}
