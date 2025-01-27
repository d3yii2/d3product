<?php

namespace d3yii2\d3product\dictionaries;

use Yii;
use d3yii2\d3product\models\D3productInputType;
use yii\helpers\ArrayHelper;

class D3productInputTypeDictionary
{

    private const CACHE_KEY_LIST = 'D3productInputTypeDictionaryList';
    private const CACHE_KEY_LIST_ALL = 'D3productInputTypeDictionaryListAll';


    /**
    * @return string[]
    */
    public static function getList(int $sysCompanyId): array
    {
        return Yii::$app->cache->getOrSet(
            self::createCacheKey($sysCompanyId),
            static function () use ($sysCompanyId) {
                return ArrayHelper::map(
                    D3productInputType::find()
                        ->select([
                            'id' => '`d3product_input_type`.`id`' ,
                            'name' => '`d3product_input_type`.`name`',
                            //'name' => 'CONCAT(code,\' \',name)'
                        ])
                        ->andWhere(['`d3product_input_type`.`sys_company_id`' => $sysCompanyId])                        ->orderBy([
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
    * @return string[]
    */
    public static function getAllList(): array
    {
        return Yii::$app->cache->getOrSet(
            self::CACHE_KEY_LIST_ALL,
            static function () {
                return ArrayHelper::map(
                    D3productInputType::find()
                        ->select([
                            'id' => '`d3product_input_type`.`id`' ,
                            'name' => '`d3product_input_type`.`name`',
                            //'name' => 'CONCAT(code,\' \',name)'
                        ])
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
        return self::getList($sysCompanyId)[$id]??null;
    }

    private static function createCacheKey(int $sysCompanyId): string
    {
        return self::CACHE_KEY_LIST . '-' . $sysCompanyId;
    }

    public static function clearCache(): void
    {
        Yii::$app->cache->delete(self::CACHE_KEY_LIST_ALL);
        foreach (D3productInputType::find()
            ->distinct()
            ->select('sys_company_id')
            ->column() as $sysCompanyId
        ) {
            Yii::$app->cache->delete(self::createCacheKey($sysCompanyId));
        }
    }
}
