<?php

namespace d3yii2\d3product\dictionaries;

use d3yii2\d3product\models\D3productProductType;
use Yii;
use yii\helpers\ArrayHelper;

class D3productProductTypeDictionary
{

    private const CACHE_KEY_LIST = 'D3productProductTypeDictionaryList';

    /**
     * get id by name
     * @param int $sysCompanyId
     * @param string $name
     * @return int|null
     */
    public static function findIdByName(int $sysCompanyId, string $name): ?int
    {
        $id = array_search($name, self::getList($sysCompanyId), true);
        return $id === false ? null : $id;
    }
    public static function getList(int $sysCompanyId): array
    {
        return Yii::$app->cache->getOrSet(
            self::createCacheKey($sysCompanyId),
            static function () use ($sysCompanyId) {
                return ArrayHelper::map(
                    D3productProductType::find()
                        ->select([
                            'id' => '`d3product_product_type`.`id`',
                            'name' => '`d3product_product_type`.`name`',
                            //'name' => 'CONCAT(code,\' \',name)'
                        ])
                        ->andWhere(['`d3product_product_type`.`sys_company_id`' => [$sysCompanyId, null]])
                        ->orderBy([
                            '`d3product_product_type`.`name`' => SORT_ASC,
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
        foreach (D3productProductType::find()
                     ->distinct()
                     ->select('sys_company_id')
                     ->column() as $sysCompanyId
        ) {
            Yii::$app->cache->delete(self::createCacheKey($sysCompanyId));
        }
    }
}
