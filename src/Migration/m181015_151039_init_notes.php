<?php

use yii\db\Migration;

/**
 * Class m181015_151039_init_notes
 */
class m181015_151039_init_notes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /**
         * notes
         */
        $this->execute("CREATE TABLE `notes` (
            `note_id` int(10) UNSIGNED NOT NULL,
            `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
            `title` varchar(255) NOT NULL DEFAULT '',
            `note` mediumtext,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->execute("ALTER TABLE `notes` ADD PRIMARY KEY (`note_id`), ADD KEY `user_id` (`user_id`)");

        $this->execute("ALTER TABLE `notes` MODIFY `note_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181015_151039_init_notes cannot be reverted.\n";

        return false;
    }
}
