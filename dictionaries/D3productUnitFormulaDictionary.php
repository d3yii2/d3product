<?php

namespace d3yii2\d3product\dictionaries;

use Yii;
use d3yii2\d3product\models\D3productUnitFormula;
use yii\helpers\ArrayHelper;

class D3productUnitFormulaDictionary
{

    private const CACHE_KEY_LIST = 'D3productUnitFormulaDictionaryList';
    public static function getList(): array
    {
        return Yii::$app->cache->getOrSet(
            self::CACHE_KEY_LIST,
            static function () {
                return ArrayHelper::map(
                    D3productUnitFormula::find()
                        ->select([
                            'id' => '`d3product_unit_formula`.`id`' ,
                            'name' => 'CONCAT_WS(\' \',`d3product_unit_formula`.`code`,unitFrom.code,\'>\',unitTo.code)',
                        ])
                        ->innerJoin('d3product_unit unitFrom', 'unitFrom.id = d3product_unit_formula.from_unit_id')
                        ->innerJoin('d3product_unit unitTo', 'unitTo.id = d3product_unit_formula.to_unit_id')
                        ->orderBy([
                            '`d3product_unit_formula`.`code`' => SORT_ASC,
                        ])
                        ->asArray()
                        ->all(),
                    'id',
                    'name'
                );
            },
            60 * 60
        );
    }


    /**
    * get label
    * @param int $id
    * @return string|null
    */
    public static function getLabel(int $id)
    {
        return self::getList()[$id]??null;
    }

    public static function clearCache(): void
    {
        Yii::$app->cache->delete(self::CACHE_KEY_LIST);
    }


}
