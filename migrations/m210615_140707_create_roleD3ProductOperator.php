<?php



use yii\db\Migration;
use d3yii2\d3product\accessRights\D3ProductOperatorUserRole;

class m210615_140707_create_roleD3ProductOperator  extends Migration {

    public function up() {

        $auth = Yii::$app->authManager;
        $role = $auth->createRole(D3ProductOperatorUserRole::NAME);
        $auth->add($role);

    }

    public function down() {
        $auth = Yii::$app->authManager;
        $role = $auth->createRole(D3ProductOperatorUserRole::NAME);
        $auth->remove($role);
    }
}
