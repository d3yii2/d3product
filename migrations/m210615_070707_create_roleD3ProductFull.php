<?php



use yii\db\Migration;
use d3yii2\d3product\accessRights\D3ProductFullUserRole;

class m210615_070707_create_roleD3ProductFull  extends Migration {

    public function up() {

        $auth = Yii::$app->authManager;
        $role = $auth->createRole(D3ProductFullUserRole::NAME);
        $auth->add($role);

    }

    public function down() {
        $auth = Yii::$app->authManager;
        $role = $auth->createRole(D3ProductFullUserRole::NAME);
        $auth->remove($role);
    }
}
