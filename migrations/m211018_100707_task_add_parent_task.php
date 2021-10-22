<?php

use yii\db\Migration;

class m211018_100707_task_add_parent_task  extends Migration {

    public function safeUp() { 
        $this->execute('
            ALTER TABLE `m_task`
              ADD COLUMN `parent_task_id` SMALLINT UNSIGNED NULL COMMENT \'Parent task\' AFTER `id`,
              ADD COLUMN `form_data` LONGTEXT CHARSET utf8 NULL COMMENT \'Form Data\' AFTER `notes`,
              ADD CONSTRAINT `m_task_ibfk_parent_task` FOREIGN KEY (`parent_task_id`) REFERENCES `m_task` (`id`);
            
                    
        ');
    }

    public function safeDown() {
        echo "m211018_100707_task_add_parent_task cannot be reverted.\n";
        return false;
    }
}
