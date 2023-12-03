<?php

use yii\base\InvalidConfigException;
use yii\db\Migration;
use yii\rbac\DbManager;

/**
 * Class m231203_110033_add_rbac_items
 */
class m231203_110033_add_rbac_items extends Migration
{
    /**
     * {@inheritdoc}
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function safeUp()
    {
        $auth = $this->getAuthManager();

        $adminRole = $auth->createRole('admin');
        $adminRole->description = "Роль - администратор";
        $auth->add($adminRole);

        $userRole = $auth->createRole('user');
        $userRole->description = "Роль - пользователь";
        $auth->add($userRole);

        $listBookPermission = $auth->createPermission('listBooks');
        $listBookPermission->description = 'Может просматривать список книг';
        $auth->add($listBookPermission);

        $viewBookPermission = $auth->createPermission('viewBook');
        $viewBookPermission->description = 'Может просматривать отельную книгу';
        $auth->add($viewBookPermission);

        $createBookPermission = $auth->createPermission('createBook');
        $createBookPermission->description = 'Может создавать книгу';
        $auth->add($createBookPermission);

        $updateBookPermission = $auth->createPermission('updateBook');
        $updateBookPermission->description = 'Может редактировать книгу';
        $auth->add($updateBookPermission);

        $deleteBookPermission = $auth->createPermission('deleteBook');
        $deleteBookPermission->description = 'Может удалить книгу';
        $auth->add($deleteBookPermission);

        $subscribeBookPermission = $auth->createPermission('subscribeBook ');
        $subscribeBookPermission->description = 'Может может подписываться на книгу';
        $auth->add($subscribeBookPermission);

        $viewReportPermission = $auth->createPermission('viewReport');
        $viewReportPermission->description = 'Может просматривать отчет';
        $auth->add($viewReportPermission);

        $auth->addChild($userRole, $listBookPermission);
        $auth->addChild($userRole, $viewBookPermission);
        $auth->addChild($userRole, $subscribeBookPermission);
        $auth->addChild($userRole, $viewReportPermission);

        $auth->addChild($adminRole, $userRole);
        $auth->addChild($adminRole, $createBookPermission);
        $auth->addChild($adminRole, $updateBookPermission);
        $auth->addChild($adminRole, $deleteBookPermission);

        $auth->assign($adminRole, 1);
        $auth->assign($userRole, 2);

    }

    /**
     * {@inheritdoc}
     * @throws InvalidConfigException
     */
    public function safeDown()
    {
        $auth = $this->getAuthManager();
        $auth->removeAll();
    }

    /**
     * @throws InvalidConfigException
     */
    protected function getAuthManager(): DbManager
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('Вы должны сконфигурировать "authManager" компонент.');
        }
        return $authManager;
    }
}
