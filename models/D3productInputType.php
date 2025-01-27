<?php

namespace d3yii2\d3product\models;

use d3yii2\d3product\dictionaries\D3productInputTypeDictionary;
use d3yii2\d3product\models\base\D3productInputType as BaseD3productInputType;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "d3product_input_type".
 */
class D3productInputType extends BaseD3productInputType
{
    /**
     * @return ActiveQuery
     */
    public function getD3productAttributes(): ActiveQuery
    {
        return $this
            ->hasMany(D3productAttributes::class, ['input_type_id' => 'id'])
            ->inverseOf('inputType');
    }
    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);
        D3productInputTypeDictionary::clearCache();
    }

    public function afterDelete(): void
    {
        parent::afterDelete();
        D3productInputTypeDictionary::clearCache();
    }
}
