<?php

namespace d3yii2\d3product\models;

use \d3yii2\d3product\models\base\D3productInputType as BaseD3productInputType;

/**
 * This is the model class for table "d3product_input_type".
 */
class D3productInputType extends BaseD3productInputType
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getD3productAttributes()
    {
        return $this
            ->hasMany(D3productAttributes::class, ['input_type_id' => 'id'])
            ->inverseOf('inputType');
    }
}
