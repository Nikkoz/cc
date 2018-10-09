<?php

use yii\db\Migration;

/**
 * Class m180904_094645_add_fields_to_user
 */
class m180904_094645_add_fields_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%user}}', 'name', $this->string()->after('username'));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('{{%user}}', 'name');
    }
}
