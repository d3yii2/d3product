<?php


namespace d3yii2\d3product\components\InputType;

use d3yii2\d3product\models\D3productAttributes;
use d3yii2\d3product\models\D3productInputType;
use kartik\form\ActiveForm;
use yii\base\Exception;

class CsvDataList
{
    /**
     * @var \kartik\form\ActiveForm
     */
    private $form;
    /**
     * @var \d3yii2\d3product\models\D3productAttributes
     */
    private $attribute;

    /** @var int */
    private $i;

    public function __construct(
        ActiveForm $form,
        D3productAttributes $attribute,
        int $i
    )
    {
        $this->form = $form;
        $this->attribute = $attribute;
        $this->i = $i;
    }

    public function createField(): string
    {
        if (!$inputType = D3productInputType::findOne($this->attribute->input_type_id)) {
            throw new Exception('Can not find input type for product attribute id: ' . $this->attribute->id);
        }
        $list = explode(',', $inputType->data);
        $list = array_combine($list, $list);
        return $this
            ->form
            ->field($this->attribute, '[' . $this->i . ']value')
            ->dropDownList($list)
            ->label($this->attribute->name)
            ;
    }
}