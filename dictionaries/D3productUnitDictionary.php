<?php

namespace d3yii2\d3product\dictionaries;

use d3yii2\d3product\models\D3productUnit;
use Yii;
use yii\helpers\ArrayHelper;

class D3productUnitDictionary
{

    private const CACHE_KEY_LIST = 'D3productUnitDictionaryList';

    public static function getList(int $sysCompanyId = null): array
    {
        if (!$sysCompanyId) {
            $sysCompanyId = Yii::$app->SysCmp->getActiveCompanyId();
        }
        return Yii::$app->cache->getOrSet(
            self::createCacheKey($sysCompanyId),
            static function () use ($sysCompanyId) {
                return ArrayHelper::map(
                    D3productUnit::find()
                        ->select([
                            'id' => '`d3product_unit`.`id`',
                            'name' => '`d3product_unit`.`code`',
                            //'name' => 'CONCAT(code,\' \',name)'
                        ])
                        ->andWhere(['`d3product_unit`.`sys_company_id`' => $sysCompanyId])
                        ->orderBy([
                            '`d3product_unit`.`code`' => SORT_ASC,
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
     * @param int $sysCompanyId
     * @param int $id
     * @return string|null
     */
    public static function getLabel(int $sysCompanyId, ?int $id): ?string
    {
        return self::getList($sysCompanyId)[$id] ?? null;
    }

    private static function createCacheKey($sysCompanyId): string
    {
        return self::CACHE_KEY_LIST . '-' . $sysCompanyId;
    }

    public static function clearCache(): void
    {
        foreach (D3productUnit::find()
                     ->distinct()
                     ->select('sys_company_id')
                     ->column() as $sysCompanyId
        ) {
            Yii::$app->cache->delete(self::createCacheKey($sysCompanyId));
        }
    }
}
