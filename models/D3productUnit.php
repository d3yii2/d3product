<?php

namespace d3yii2\d3product\models;

use d3yii2\d3product\dictionaries\D3productUnitDictionary;
use \d3yii2\d3product\models\base\D3productUnit as BaseD3productUnit;

/**
 * This is the model class for table "d3product_unit".
 */
class D3productUnit extends BaseD3productUnit
{
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        D3productUnitDictionary::clearCache();
    }

    public function afterDelete()
    {
        parent::afterDelete();
        D3productUnitDictionary::clearCache();
    }

    public static function optsUnit(int $sysCompanyId): array
    {
        return D3productUnitDictionary::getList($sysCompanyId);
    }

}
