<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190902_113920_initial_structure
 */
class m190902_113920_initial_structure extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('domain', [
            'id' => Schema::TYPE_PK,
            'domain' => Schema::TYPE_STRING
        ]);

        $this->createIndex('ux_domain', 'domain', 'domain', true);

        $this->createTable('tld', [
            'id' => Schema::TYPE_PK,
            'tld' => Schema::TYPE_STRING,
            'price' => Schema::TYPE_DOUBLE
        ]);

        $this->createIndex('ux_tld', 'tld', 'tld', true);

        $this->insert('domain', [
            'domain' => 'existing.com',
        ]);

        $this->insert('tld', [
            'tld' => 'com',
            'price' => 8.99,
        ]);

        $this->insert('tld', [
            'tld' => 'net',
            'price' => 9.99,
        ]);

        $this->insert('tld', [
            'tld' => 'club',
            'price' => 15.99,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('domain');
        $this->dropTable('tld');
        return false;
    }

}
