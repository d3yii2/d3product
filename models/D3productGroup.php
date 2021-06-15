<?php

namespace d3yii2\d3product\models;

use d3yii2\d3product\dictionaries\D3productGroupDictionary;
use \d3yii2\d3product\models\base\D3productGroup as BaseD3productGroup;

/**
 * This is the model class for table "d3product_group".
 */
class D3productGroup extends BaseD3productGroup
{
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        D3productGroupDictionary::clearCache();
    }

    public function afterDelete()
    {
        parent::afterDelete();
        D3productGroupDictionary::clearCache();
    }
}
