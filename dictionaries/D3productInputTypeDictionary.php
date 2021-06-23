<?php

namespace d3yii2\d3product\dictionaries;

use d3yii2\d3product\models\D3productInputType;
use Yii;
use yii\helpers\ArrayHelper;

class D3productInputTypeDictionary
{

    private const CACHE_KEY_LIST = 'D3productInputTypeDictionaryList';

    public static function getList(int $sysCompanyId): array
    {
        return Yii::$app->cache->getOrSet(
            self::createCacheKey($sysCompanyId),
            static function () use ($sysCompanyId) {
                return ArrayHelper::map(
                    D3productInputType::find()
                        ->select([
                            'id' => '`d3product_input_type`.`id`',
                            'name' => '`d3product_input_type`.`name`',
                        ])
                        ->andWhere(['`d3product_input_type`.`sys_company_id`' => [$sysCompanyId, null]])
                        ->orderBy([
                            '`d3product_input_type`.`name`' => SORT_ASC,
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
    public static function getLabel(int $sysCompanyId, int $id): ?string
    {
        return self::getList($sysCompanyId)[$id] ?? null;
    }

    private static function createCacheKey($sysCompanyId): string
    {
        return self::CACHE_KEY_LIST . '-' . $sysCompanyId;
    }

    public static function clearCache(): void
    {
        foreach (D3productInputType::find()
                     ->distinct()
                     ->select('sys_company_id')
                     ->column() as $sysCompanyId
        ) {
            Yii::$app->cache->delete(self::createCacheKey($sysCompanyId));
        }
    }

}

