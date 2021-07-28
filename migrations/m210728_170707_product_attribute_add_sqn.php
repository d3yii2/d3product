<?php

use yii\db\Migration;

class m210728_170707_product_attribute_add_sqn  extends Migration {

    public function safeUp() { 
        $this->execute('
            ALTER TABLE `d3product_attributes`   
              ADD COLUMN `sqn` TINYINT UNSIGNED NULL  COMMENT \'SQN\' AFTER `product_id`        
        ');
    }

    public function safeDown() {
        echo "m210728_170707_product_attribute_add_sqn cannot be reverted.\n";
        return false;
    }
}
