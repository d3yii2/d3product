<?php

use yii\db\Migration;

class m210728_170707_product_type_ad_sqn  extends Migration {

    public function safeUp() { 
        $this->execute('
            ALTER TABLE `d3product_type_attributes`   
              ADD COLUMN `sqn` TINYINT UNSIGNED NULL  COMMENT \'SQN\' AFTER `product_type_id`;
                    
        ');
    }

    public function safeDown() {
        echo "m210728_170707_product_type_ad_sqn cannot be reverted.\n";
        return false;
    }
}
