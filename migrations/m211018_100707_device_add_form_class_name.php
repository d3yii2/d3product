<?php

use yii\db\Migration;

class m211018_100707_device_add_form_class_name  extends Migration {

    public function safeUp() { 
        $this->execute('
            ALTER TABLE `m_device`
              ADD COLUMN `form_class_name` TEXT NULL AFTER `code`;
            
                    
        ');
    }

    public function safeDown() {
        echo "m211018_100707_device_add_form_class_name cannot be reverted.\n";
        return false;
    }
}
