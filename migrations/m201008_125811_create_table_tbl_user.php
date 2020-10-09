<?php

use yii\db\Migration;

/**
 * Class m201008_125811_create_table_tbl_user
 */
class m201008_125811_create_table_tbl_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tbl_user', [
           'id' => $this->primaryKey(11),
            'full_name' => $this->string(255)->notNull(),
            'username' => $this->string(30)->notNull(),
            'email' => $this->string(100)->notNull(),
            'password' => $this->string(255)->notNull(),
            'auth_key' => $this->string(255)->notNull(),
            'token_id' => $this->string(100)->notNull(),
            'active' => $this->boolean()->defaultValue(false)->notNull(),
            'create_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull()
        ]);

        /**
         * Default user: admin123 with the password: admin123
         * If you dont need default user remove this code and the one in safeDown
         */

        $this->insert('tbl_user', [
           'full_name' => 'Administrator',
           'username' => 'admin123',
           'email' => 'admin@noemail.com',
           'password' => md5('admin123'),
           'auth_key' => Yii::$app->security->generateRandomString(32),
            'token_id' => Yii::$app->security->generateRandomString(32),
            'active' => true
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /**
         * Remove this code if you are not going to use predefine user data
         */
        $this->delete('tbl_user');

        $this->dropTable('tbl_user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201008_125811_create_table_tbl_user cannot be reverted.\n";

        return false;
    }
    */
}
