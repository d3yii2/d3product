<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace d3yii2\d3product\models\base;

use Yii;

/**
 * This is the base-model class for table "d3product_input_type".
 *
 * @property integer $id
 * @property integer $sys_company_id
 * @property string $name
 * @property string $input_class
 * @property string $data
 *
 * @property \d3yii2\d3product\models\D3productTypeAttributes[] $d3productTypeAttributes
 * @property string $aliasModel
 */
abstract class D3productInputType extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'd3product_input_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'tinyint Unsigned' => [['id'],'integer' ,'min' => 0 ,'max' => 255],
            'smallint Unsigned' => [['sys_company_id'],'integer' ,'min' => 0 ,'max' => 65535],
            [['data'], 'string'],
            [['name'], 'string', 'max' => 30],
            [['input_class'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('productadmin', 'ID'),
            'sys_company_id' => Yii::t('productadmin', 'Sys Company ID'),
            'name' => Yii::t('productadmin', 'Name'),
            'input_class' => Yii::t('productadmin', 'Input Class'),
            'data' => Yii::t('productadmin', 'Data'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getD3productTypeAttributes()
    {
        return $this->hasMany(\d3yii2\d3product\models\D3productTypeAttributes::className(), ['input_type_id' => 'id'])->inverseOf('inputType');
    }

}
