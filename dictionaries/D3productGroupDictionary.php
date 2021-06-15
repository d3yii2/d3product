<?php

namespace d3yii2\d3product\dictionaries;

use Yii;
use d3yii2\d3product\models\D3productGroup;
use yii\helpers\ArrayHelper;

class D3productGroupDictionary{

    private const CACHE_KEY_LIST = 'D3productGroupDictionaryList';
    public static function getList(int $sysCompanyId): array
    {
        return Yii::$app->cache->getOrSet(
            self::createCacheKey($sysCompanyId),
            static function () use ($sysCompanyId) {
                return ArrayHelper::map(
                    D3productGroup::find()
                    ->select([
                        'id' => '`d3product_group`.`id`' ,
                        'name' => '`d3product_group`.`name`',
                        //'name' => 'CONCAT(code,\' \',name)'
                    ])
                    ->andWhere(['`d3product_group`.`sys_company_id`' => $sysCompanyId])                    ->orderBy([
                        '`d3product_group`.`name`' => SORT_ASC,
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
    public static function getLabel(int $sysCompanyId, int $id)
    {
        return self::getList($sysCompanyId)[$id]??null;
    }

    private static function createCacheKey($sysCompanyId)    {
        return self::CACHE_KEY_LIST . '-' . $sysCompanyId ;
    }

    public static function clearCache(): void
    {
        foreach (D3productGroup::find()
            ->distinct()
            ->select('sys_company_id')
            ->column() as $sysCompanyId
        ) {
            Yii::$app->cache->delete(self::createCacheKey($sysCompanyId));
        }
    }
    
}
