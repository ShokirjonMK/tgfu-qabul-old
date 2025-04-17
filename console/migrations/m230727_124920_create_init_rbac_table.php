<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%init_rbac}}`.
 */
class m230727_124920_create_init_rbac_table extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $supper_admin = $auth->createRole('supper_admin');
        $supper_admin->description = 'Supper admin';
        $auth->add($supper_admin);
        $auth->assign($supper_admin, 1);

        $director = $auth->createRole('director');
        $director->description = 'Direktor';
        $auth->add($director);

        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator';
        $auth->add($admin);

        $teacher = $auth->createRole('moderator');
        $teacher->description = 'O\'qituvchi';
        $auth->add($teacher);

        $student = $auth->createRole('student');
        $student->description = 'O\'quvchi';
        $auth->add($student);
    }

    /**
     * {@inheritdoc}
     */

    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}
