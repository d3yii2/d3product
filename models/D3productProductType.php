<?php

namespace d3yii2\d3product\models;

use d3yii2\d3product\dictionaries\D3productProductTypeDictionary;
use d3yii2\d3product\models\base\D3productProductType as BaseD3productProductType;

/**
 * This is the model class for table "d3product_product_type".
 */
class D3productProductType extends BaseD3productProductType
{
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        D3productProductTypeDictionary::clearCache();
    }

    public function afterDelete()
    {
        parent::afterDelete();
        D3productProductTypeDictionary::clearCache();
    }

    public static function optsProductType(int $sysCompanyId): array
    {
        return D3productProductTypeDictionary::getList($sysCompanyId);
    }
}
