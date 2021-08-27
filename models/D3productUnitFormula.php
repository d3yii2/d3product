<?php

namespace d3yii2\d3product\models;

use d3yii2\d3product\dictionaries\D3productUnitFormulaDictionary;
use \d3yii2\d3product\models\base\D3productUnitFormula as BaseD3productUnitFormula;

/**
 * This is the model class for table "d3product_unit_formula".
 */
class D3productUnitFormula extends BaseD3productUnitFormula
{
    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);
        D3productUnitFormulaDictionary::clearCache();
    }

    public function afterDelete(): void
    {
        parent::afterDelete();
        D3productUnitFormulaDictionary::clearCache();
    }

    public static function optsUnit(): array
    {
        return D3productUnitFormulaDictionary::getList();
    }


    public function calc($attributes, $qnt)
    {
        $formulaObject = new $this->formula;
        $formulaObject->loadAttributes($attributes);

        if (($calcQnt = $formulaObject->calc($qnt)) === false) {
            return null;
        }

        return $calcQnt;
    }
}
