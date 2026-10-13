<?php

use yii\db\Exception;
use yii\db\Migration;

class m261013_152416_d3yii2_d3product_price_precision extends Migration
{
    /**
     * @throws Exception
     */
    public function safeUp()
    {
        $this->alterColumn(
            'd3product_price',
            'price',
            $this->decimal(12, 4)->unsigned()->notNull()->comment('Price')
        );
    }

    public function safeDown()
    {
        echo "m261013_152416_d3yii2_d3product_price_precision cannot be reverted.\n";
        return false;
    }
}
