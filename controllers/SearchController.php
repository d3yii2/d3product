<?php

namespace d3yii2\d3product\controllers;

use d3yii2\d3product\dictionaries\D3productProductDictionary;
use d3yii2\d3product\Module;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * D3recipeProductOutController implements the CRUD actions for D3recipeProductOut model.
 * @property Module $module
 */
class SearchController extends Controller
{
    /**
     * @var boolean whether to enable CSRF validation for the actions in this controller.
     * CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
     */
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'ajax',
                        ],
                        'roles' => $this->module->rolesSearchAjax,
                    ],
                ],
            ],
        ];
    }

    public function actionAjax(string $q = ''): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        try {
            return [
                'results' => D3productProductDictionary::searchByGroupTypeName(Yii::$app->SysCmp->getActiveCompanyId(), $q)
            ];
        } catch (Exception $e) {
            Yii::error('error', $e->getMessage());
            return [
                'results' => [],
                'error' => 'Unexpected error'
            ];
        }
    }
}
