<?php

use yii\db\Migration;

class m210707_120707_atributes_encoding  extends Migration {

    public function safeUp() { 
        $this->execute('
            ALTER TABLE `d3product_attributes`
              CHANGE `name` `name` VARCHAR (250) CHARSET utf8 NULL COMMENT \'Name\',
              CHANGE `value` `value` VARCHAR (50) CHARSET utf8 NULL COMMENT \'Value\';
            
                    
        ');
    }

    public function safeDown() {
        echo "m210707_120707_atributes_encoding cannot be reverted.\n";
        return false;
    }
}
