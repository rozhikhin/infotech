<?php

use yii\db\Migration;

/**
 * Class m231130_103818_add_default_admin_and_user
 */
class m231130_103818_add_default_admin_and_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('user', [
            'username' => 'admin',
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('admin'),
            'email' => 'admin@admin.ru',
            'status' => 10,
            'created_at' => 0,
            'updated_at' => 0,
        ]);

        $this->insert('user', [
            'username' => 'user',
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('user'),
            'email' => 'user@user.ru',
            'status' => 10,
            'created_at' => 0,
            'updated_at' => 0,
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('user', ['email' => 'admin@admin.ru']);
        $this->delete('user', ['email' => 'user@user.ru']);
    }

}
