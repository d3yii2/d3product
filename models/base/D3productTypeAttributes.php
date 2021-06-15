<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace d3yii2\d3product\models\base;

use Yii;


/**
 * This is the base-model class for table "d3product_type_attributes".
 *
 * @property integer $id
 * @property integer $product_type_id
 * @property string $name
 * @property integer $input_type_id
 *
 * @property \d3yii2\d3product\models\D3productAttributes[] $d3productAttributes
 * @property \d3yii2\d3product\models\D3productInputType $inputType
 * @property \d3yii2\d3product\models\D3productProductType $productType
 * @property string $aliasModel
 */
abstract class D3productTypeAttributes extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'd3product_type_attributes';
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = [
        ];
        return $behaviors;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'required' => [['input_type_id'], 'required'],
            'tinyint Unsigned' => [['input_type_id'],'integer' ,'min' => 0 ,'max' => 255],
            'smallint Unsigned' => [['id','product_type_id'],'integer' ,'min' => 0 ,'max' => 65535],
            [['name'], 'string', 'max' => 50],
            [['input_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => \d3yii2\d3product\models\D3productInputType::className(), 'targetAttribute' => ['input_type_id' => 'id']],
            [['product_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => \d3yii2\d3product\models\D3productProductType::className(), 'targetAttribute' => ['product_type_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('d3labels', 'ID'),
            'product_type_id' => Yii::t('d3labels', 'Product Type'),
            'name' => Yii::t('d3labels', 'Attribute Name'),
            'input_type_id' => Yii::t('d3labels', 'Input Type'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints(): array
    {
        return array_merge(parent::attributeHints(), [
            'product_type_id' => Yii::t('d3labels', 'Product Type'),
            'name' => Yii::t('d3labels', 'Attribute Name'),
            'input_type_id' => Yii::t('d3labels', 'Input Type'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getD3productAttributes()
    {
        return $this->hasMany(\d3yii2\d3product\models\D3productAttributes::className(), ['type_attribute_id' => 'id'])->inverseOf('typeAttribute');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputType()
    {
        return $this->hasOne(\d3yii2\d3product\models\D3productInputType::className(), ['id' => 'input_type_id'])->inverseOf('d3productTypeAttributes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductType()
    {
        return $this->hasOne(\d3yii2\d3product\models\D3productProductType::className(), ['id' => 'product_type_id'])->inverseOf('d3productTypeAttributes');
    }




}
