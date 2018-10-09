<?php
use yii\db\Migration;

/**
 * Class m180717_111654_create_db_tables
 */
class m180717_111654_create_db_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%landing_settings}}', [
            'id' => $this->primaryKey(),
            'settings' => $this->text(),
        ], $tableOptions);

        $this->createTable('{{%coupons}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'type' => $this->boolean(),
            'discount' => $this->integer(),
            'publish' => $this->boolean()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('IDX_coupons_user_created_by', '{{%coupons}}', 'created_by');
        $this->addForeignKey('IDX_coupons_user_created_by', '{{%coupons}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_coupons_user_updated_by', '{{%coupons}}', 'updated_by');
        $this->addForeignKey('IDX_coupons_user_updated_by', '{{%coupons}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createTable('{{%formula}}', [
            'id' => $this->primaryKey(),
            'news_max_val' => $this->integer(),
            'news_max_count' => $this->integer(),
            'community_max_val' => $this->integer(),
            'community_max_count' => $this->integer(),
            'developers_max_val' => $this->integer(),
            'developers_max_count' => $this->integer(),
            'exchanges_max_val' => $this->integer(),
            'exchanges_max_count' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%landing_blocks}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'phrase_one' => $this->string(),
            'phrase_two' => $this->string(),
            'phrase_three' => $this->text(),
        ], $tableOptions);

        $this->createTable('{{%settings_sites}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'alias' => $this->string(),
            'link' => $this->string(),
            'publish' => $this->boolean()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('IDX_ss_user_created_by', '{{%settings_sites}}', 'created_by');
        $this->addForeignKey('IDX_ss_user_created_by', '{{%settings_sites}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_ss_user_updated_by', '{{%settings_sites}}', 'updated_by');
        $this->addForeignKey('IDX_ss_user_updated_by', '{{%settings_sites}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createTable('{{%social_network}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'alias' => $this->string(),
            'link' => $this->string(),
            'publish' => $this->boolean()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('IDX_sn_user_created_by', '{{%social_network}}', 'created_by');
        $this->addForeignKey('IDX_sn_user_created_by', '{{%social_network}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_sn_user_updated_by', '{{%social_network}}', 'updated_by');
        $this->addForeignKey('IDX_sn_user_updated_by', '{{%social_network}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createTable('{{%landing_blocks_elements}}', [
            'id' => $this->primaryKey(),
            'block_id' => $this->integer(),
            'image' => $this->string(),
            'text' => $this->text(),
            'preview' => $this->text(),
            'number' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('IDX_lbe_user_created_by', '{{%landing_blocks_elements}}', 'created_by');
        $this->addForeignKey('IDX_lbe_user_created_by', '{{%landing_blocks_elements}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_lbe_user_updated_by', '{{%landing_blocks_elements}}', 'updated_by');
        $this->addForeignKey('IDX_lbe_user_updated_by', '{{%landing_blocks_elements}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_lbe_block_id', '{{%landing_blocks_elements}}', 'block_id');
        $this->addForeignKey('IDX_lbe_block_id', '{{%landing_blocks_elements}}', 'block_id', '{{%landing_blocks}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%exchanges}}', [
            'id' => $this->primaryKey(),
            'link' => $this->string(),
            'name' => $this->string(),
            'type' => $this->integer()->null(),
            'description' => $this->text(),
            'publish' => $this->boolean()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('IDX_exchanges_user_created_by', '{{%exchanges}}', 'created_by');
        $this->addForeignKey('IDX_exchanges_user_created_by', '{{%exchanges}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_exchanges_user_updated_by', '{{%exchanges}}', 'updated_by');
        $this->addForeignKey('IDX_exchanges_user_updated_by', '{{%exchanges}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_exchanges_type', '{{%exchanges}}', 'type');
        $this->addForeignKey('IDX_exchanges_type', '{{%exchanges}}', 'type', '{{%social_network}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createTable('{{%seo}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'alias' => $this->string(),
            'seo_title' => $this->string(),
            'seo_keywords' => $this->string(),
            'seo_description' => $this->text(),
        ], $tableOptions);

        $this->createTable('{{%algorithm_encryption}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%algorithm_consensus}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%coins}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'code' => $this->string(20), // код монеты, например BTC
            'alias' => $this->string(100),
            'image' => $this->integer()->null(),
            'site' => $this->text(),
            'link' => $this->text(),
            //'forum' => $this->text(),
            'chat' => $this->text(),
            'source_code' => $this->text(),
            'type' => $this->boolean()->defaultValue(0),
            'smart_contracts' => $this->boolean(),
            'platform' => $this->string(),
            'date_start' => $this->string(50),
            'encryption_id' => $this->integer(),
            'consensus_id' => $this->integer(),
            'mining' => $this->boolean()->defaultValue(0),
            'max_supply' => $this->string(),
            'key_features' => $this->text(),
            'use' => $this->text(),
            'publish' => $this->boolean()->defaultValue(1),
            //'check_case' => $this->boolean()->defaultValue(0),
            'meta' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('IDX_coins_pictures_image', '{{%coins}}', 'image');
        $this->addForeignKey('IDX_coins_pictures_image', '{{%coins}}', 'image', '{{%pictures}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_coins_user_created_by', '{{%coins}}', 'created_by');
        $this->addForeignKey('IDX_coins_user_created_by', '{{%coins}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_coins_user_updated_by', '{{%coins}}', 'updated_by');
        $this->addForeignKey('IDX_coins_user_updated_by', '{{%coins}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_coin_encryption_id', '{{%coins}}', 'encryption_id');
        $this->addForeignKey('IDX_coin_encryption_id', '{{%coins}}', 'encryption_id', '{{%algorithm_encryption}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_coin_consensus_id', '{{%coins}}', 'consensus_id');
        $this->addForeignKey('IDX_coin_consensus_id', '{{%coins}}', 'consensus_id', '{{%algorithm_consensus}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createTable('{{%blog}}', [
            'id' => $this->primaryKey(),
            'image' => $this->integer(),
            'coin_id' => $this->integer(),
            'title' => $this->string(),
            'alias' => $this->string(),
            'date' => $this->integer(),
            'index' => $this->integer(4),
            'direction' => $this->string(10),
            'views' => $this->integer(),
            'likes' => $this->integer(),
            'text' => $this->text(),
            'publish' => $this->boolean()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('IDX_blog_pictures_image', '{{%blog}}', 'image');
        $this->addForeignKey('IDX_blog_pictures_image', '{{%blog}}', 'image', '{{%pictures}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_blog_user_created_by', '{{%blog}}', 'created_by');
        $this->addForeignKey('IDX_blog_user_created_by', '{{%blog}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_blog_user_updated_by', '{{%blog}}', 'updated_by');
        $this->addForeignKey('IDX_blog_user_updated_by', '{{%blog}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_blog_coin_id', '{{%blog}}', 'coin_id');
        $this->addForeignKey('IDX_blog_coin_id', '{{%blog}}', 'coin_id', '{{%coins}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createTable('{{%coin_price}}', [
            'id' => $this->primaryKey(),
            'coin_id' => $this->integer(),
            'date' => $this->integer(),
            'price_usd' => $this->string(),
            'vol24_usd' => $this->string(),
            'price_eur' => $this->string(),
            'vol24_eur' => $this->string(),
            'price_rur' => $this->string(),
            'vol24_rur' => $this->string(),
            'btn' => $this->string(),
            'hour' => $this->boolean(),
        ], $tableOptions);

        $this->createIndex('IDX_cp_coin_id', '{{%coin_price}}', 'coin_id');
        $this->addForeignKey('IDX_cp_coin_id', '{{%coin_price}}', 'coin_id', '{{%coins}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%check_user}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'last_active' => $this->integer(),
            'page' => $this->string(),
        ], $tableOptions);

        $this->createIndex('IDX_cu_user_id', '{{%check_user}}', 'user_id');
        $this->addForeignKey('IDX_cu_user_id', '{{%check_user}}', 'user_id', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createTable('{{%favourites}}', [
            'id' => $this->primaryKey(),
            'coin_id' => $this->integer(),
            'user_id' => $this->integer(),
            'notification' => $this->boolean(),
            'index' => $this->integer(),
            'time' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('IDX_favourites_coin_id', '{{%favourites}}', 'coin_id');
        $this->addForeignKey('IDX_favourites_coin_id', '{{%favourites}}', 'coin_id', '{{%coins}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('IDX_favourites_user_id', '{{%favourites}}', 'user_id');
        $this->addForeignKey('IDX_favourites_user_id', '{{%favourites}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%social_links}}', [
            'id' => $this->primaryKey(),
            'link' => $this->string(),
            'type' => $this->integer(),
            'coin_id' => $this->integer(),
            'description' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('IDX_sl_created_by', '{{%social_links}}', 'created_by');
        $this->addForeignKey('IDX_sl_created_by', '{{%social_links}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_sl_updated_by', '{{%social_links}}', 'updated_by');
        $this->addForeignKey('IDX_sl_updated_by', '{{%social_links}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_sl_type', '{{%social_links}}', 'type');
        $this->addForeignKey('IDX_sl_type', '{{%social_links}}', 'type', '{{%social_network}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('IDX_sl_coin_id', '{{%social_links}}', 'coin_id');
        $this->addForeignKey('IDX_sl_coin_id', '{{%social_links}}', 'coin_id', '{{%coins}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%invoice}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'sum' => $this->decimal(10, 2),
            'status' => $this->string(),
        ], $tableOptions);

        $this->createIndex('IDX_invoice_user_id', '{{%invoice}}', 'user_id');
        $this->addForeignKey('IDX_invoice_user_id', '{{%invoice}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%form}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(),
            'email' => $this->string(100),
            'text'=> $this->text(),
            'created_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%forum_links}}', [
            'id' => $this->primaryKey(),
            'coin_id' => $this->integer(),
            'link' => $this->string(),
            'admin'=> $this->string(),
        ], $tableOptions);

        $this->createIndex('IDX_fl_coin_id', '{{%forum_links}}', 'coin_id');
        $this->addForeignKey('IDX_fl_coin_id', '{{%forum_links}}', 'coin_id', '{{%coins}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%forum_messages}}', [
            'id' => $this->primaryKey(),
            'forum_id' => $this->integer(),
            'user_name' => $this->string(),
            'text'=> $this->text(),
            'date' => $this->integer(),
            /*'created_at' => $this->integer(),
            'updated_at' => $this->integer(),*/
        ], $tableOptions);

        $this->createIndex('IDX_fm_forum_id', '{{%forum_messages}}', 'forum_id');
        $this->addForeignKey('IDX_fm_forum_id', '{{%forum_messages}}', 'forum_id', '{{%forum_links}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%posts}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(20),
            'post_id' => $this->string(),
            'coin_id' => $this->integer()->defaultValue(0),
            'title' => $this->string(),
            'text' => $this->text(),
            'link' => $this->string(),
            'created' => $this->integer(),
            'section' => $this->string(),
            'site_id' => $this->integer(),
            'user_id' => $this->bigInteger(),
            'user_name' => $this->string(),
            'page_name' => $this->string(),
            'shares_count' => $this->integer()->defaultValue(0),
            'likes_count' => $this->integer()->defaultValue(0),
            'comments_count' => $this->integer()->defaultValue(0),
            'likes' => $this->integer()->defaultValue(0),
            'dislikes' => $this->integer()->defaultValue(0),
            'growth' => $this->integer()->defaultValue(0),
            'decline' => $this->integer()->defaultValue(0),
            'important' => $this->integer()->defaultValue(0),
            'unimportant' => $this->integer()->defaultValue(0),
            'toxic' => $this->integer()->defaultValue(0),
            'sentiment' => $this->integer()->defaultValue(0),
            'sentiment_num' => $this->integer()->defaultValue(0),
            'publish' => $this->boolean()->defaultValue(1),
            'created_at' => $this->integer(),
            /*'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()*/
        ], $tableOptions);

        /*$this->createIndex('IDX_post_coin_id', '{{%posts}}', 'coin_id');
        $this->addForeignKey('IDX_post_coin_id', '{{%posts}}', 'coin_id', '{{%coins}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_post_site_id', '{{%posts}}', 'site_id');
        $this->addForeignKey('IDX_post_site_id', '{{%posts}}', 'site_id', '{{%settings_sites}}', 'id', 'SET NULL', 'RESTRICT');*/

        /*$this->createIndex('IDX_post_created_by', '{{%posts}}', 'created_by');
        $this->addForeignKey('IDX_post_created_by', '{{%posts}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_post_updated_by', '{{%posts}}', 'updated_by');
        $this->addForeignKey('IDX_post_updated_by', '{{%posts}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');*/

        $this->createTable('{{%handbook}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'alias' => $this->string(),
            'coin_id' => $this->integer(),
            'check_case' => $this->boolean()->defaultValue(0),
            'publish' => $this->boolean()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('IDX_handbook_coin_id', '{{%handbook}}', 'coin_id');
        $this->addForeignKey('IDX_handbook_coin_id', '{{%handbook}}', 'coin_id', '{{%coins}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('IDX_handbook_created_by', '{{%handbook}}', 'created_by');
        $this->addForeignKey('IDX_handbook_created_by', '{{%handbook}}', 'created_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createIndex('IDX_handbook_updated_by', '{{%handbook}}', 'updated_by');
        $this->addForeignKey('IDX_handbook_updated_by', '{{%handbook}}', 'updated_by', '{{%user}}', 'id', 'SET NULL', 'RESTRICT');

        $this->createTable('{{%post_handbook_assignments}}', [
            'post_id' => $this->integer(),
            'handbook_id' => $this->integer(),
        ], $tableOptions);

        $this->addPrimaryKey('PK-post_handbook_assignments', '{{%post_handbook_assignments}}', ['post_id', 'handbook_id']);

        $this->createIndex('IDX_ph_post_id', '{{%post_handbook_assignments}}', 'post_id');
        $this->addForeignKey('IDX_ph_post_id', '{{%post_handbook_assignments}}', 'post_id', '{{%posts}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('IDX_ph_handbook_id', '{{%post_handbook_assignments}}', 'handbook_id');
        $this->addForeignKey('IDX_ph_handbook_id', '{{%post_handbook_assignments}}', 'handbook_id', '{{%handbook}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%vote}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'post_id' => $this->integer(),
            //'post_type' => $this->string(20),
            'vote_type' => $this->string(20),
            'vote_val' => $this->string(20),
            'create_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('IDX_vote_user_id', '{{%vote}}', 'user_id');
        $this->addForeignKey('IDX_vote_user_id', '{{%vote}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('IDX_vote_post_id', '{{%vote}}', 'post_id');
        $this->addForeignKey('IDX_vote_post_id', '{{%vote}}', 'post_id', '{{%posts}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%saved}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'post_id' => $this->integer(),
            //'post_type' => $this->string(),
            'created_at' => $this->integer()
        ], $tableOptions);

        $this->createIndex('IDX_saved_user_id', '{{%saved}}', 'user_id');
        $this->addForeignKey('IDX_saved_user_id', '{{%saved}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('IDX_saved_post_id', '{{%saved}}', 'post_id');
        $this->addForeignKey('IDX_saved_post_id', '{{%saved}}', 'post_id', '{{%posts}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%duplicate}}', [
            'id' => $this->primaryKey(),
            'coin_id' => $this->integer(),
            'index_down' => $this->integer(),
            'index_up' => $this->integer(),
            'time_down' => $this->integer(),
            'time_up' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('IDX_fc_coin_id', '{{%duplicate}}', 'coin_id');
        $this->addForeignKey('IDX_fc_coin_id', '{{%duplicate}}', 'coin_id', '{{%coins}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%import}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(20),
            'import' => $this->boolean()->defaultValue(0),
        ], $tableOptions);

        $this->createTable('{{%pictures}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->string(255)->null(),
            'sort' => $this->integer()->defaultValue(100),
        ], $tableOptions);

        $this->createIndex('IDX_coins_image', '{{%coins}}', 'image');
        $this->addForeignKey('IDX_coins_image', '{{%coins}}', 'image', '{{%pictures}}', 'id', 'SET NULL', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('IDX_coupons_user_created_by', '{{%coupons}}');
        $this->dropIndex('IDX_coupons_user_created_by', '{{%coupons}}');

        $this->dropForeignKey('IDX_coupons_user_updated_by', '{{%coupons}}');
        $this->dropIndex('IDX_coupons_user_updated_by', '{{%coupons}}');

        $this->dropForeignKey('IDX_ss_user_created_by', '{{%settings_sites}}');
        $this->dropIndex('IDX_ss_user_created_by', '{{%settings_sites}}');

        $this->dropForeignKey('IDX_ss_user_updated_by', '{{%settings_sites}}');
        $this->dropIndex('IDX_ss_user_updated_by', '{{%settings_sites}}');

        $this->dropForeignKey('IDX_sn_user_created_by', '{{%social_network}}');
        $this->dropIndex('IDX_sn_user_created_by', '{{%social_network}}');

        $this->dropForeignKey('IDX_sn_user_updated_by', '{{%social_network}}');
        $this->dropIndex('IDX_sn_user_updated_by', '{{%social_network}}');

        $this->dropForeignKey('IDX_lbe_user_created_by', '{{%landing_blocks_elements}}');
        $this->dropIndex('IDX_lbe_user_created_by', '{{%landing_blocks_elements}}');

        $this->dropForeignKey('IDX_lbe_user_updated_by', '{{%landing_blocks_elements}}');
        $this->dropIndex('IDX_lbe_user_updated_by', '{{%landing_blocks_elements}}');

        $this->dropForeignKey('IDX_lbe_block_id', '{{%landing_blocks_elements}}');
        $this->dropIndex('IDX_lbe_block_id', '{{%landing_blocks_elements}}');

        $this->dropForeignKey('IDX_exchanges_user_created_by', '{{%exchanges}}');
        $this->dropIndex('IDX_exchanges_user_created_by', '{{%exchanges}}');

        $this->dropForeignKey('IDX_exchanges_user_updated_by', '{{%exchanges}}');
        $this->dropIndex('IDX_exchanges_user_updated_by', '{{%exchanges}}');

        $this->dropForeignKey('IDX_exchanges_type', '{{%exchanges}}');
        $this->dropIndex('IDX_exchanges_type', '{{%exchanges}}');

        $this->dropForeignKey('IDX_coins_pictures_image', '{{%coins}}');
        $this->dropIndex('IDX_coins_pictures_image', '{{%coins}}');

        $this->dropForeignKey('IDX_coins_user_created_by', '{{%coins}}');
        $this->dropIndex('IDX_coins_user_created_by', '{{%coins}}');

        $this->dropForeignKey('IDX_coins_user_updated_by', '{{%coins}}');
        $this->dropIndex('IDX_coins_user_updated_by', '{{%coins}}');

        $this->dropForeignKey('IDX_coin_encryption_id', '{{%coins}}');
        $this->dropIndex('IDX_coin_encryption_id', '{{%coins}}');

        $this->dropForeignKey('IDX_coin_consensus_id', '{{%coins}}');
        $this->dropIndex('IDX_coin_consensus_id', '{{%coins}}');

        $this->dropForeignKey('IDX_blog_user_created_by', '{{%blog}}');
        $this->dropIndex('IDX_blog_user_created_by', '{{%blog}}');

        $this->dropForeignKey('IDX_blog_user_updated_by', '{{%blog}}');
        $this->dropIndex('IDX_blog_user_updated_by', '{{%blog}}');

        $this->dropForeignKey('IDX_blog_coin_id', '{{%blog}}');
        $this->dropIndex('IDX_blog_coin_id', '{{%blog}}');

        $this->dropForeignKey('IDX_cp_coin_id', '{{%coin_price}}');
        $this->dropIndex('IDX_cp_coin_id', '{{%coin_price}}');

        $this->dropForeignKey('IDX_cu_user_id', '{{%check_user}}');
        $this->dropIndex('IDX_cu_user_id', '{{%check_user}}');

        $this->dropForeignKey('IDX_favourites_coin_id', '{{%favourites}}');
        $this->dropIndex('IDX_favourites_coin_id', '{{%favourites}}');

        $this->dropForeignKey('IDX_favourites_user_id', '{{%favourites}}');
        $this->dropIndex('IDX_favourites_user_id', '{{%favourites}}');

        $this->dropForeignKey('IDX_sl_created_by', '{{%social_links}}');
        $this->dropIndex('IDX_sl_created_by', '{{%social_links}}');

        $this->dropForeignKey('IDX_sl_updated_by', '{{%social_links}}');
        $this->dropIndex('IDX_sl_updated_by', '{{%social_links}}');

        $this->dropForeignKey('IDX_sl_type', '{{%social_links}}');
        $this->dropIndex('IDX_sl_type', '{{%social_links}}');

        $this->dropForeignKey('IDX_sl_coin_id', '{{%social_links}}');
        $this->dropIndex('IDX_sl_coin_id', '{{%social_links}}');

        $this->dropForeignKey('IDX_invoice_user_id', '{{%invoice}}');
        $this->dropIndex('IDX_invoice_user_id', '{{%invoice}}');

        $this->dropForeignKey('IDX_fl_coin_id', '{{%forum_links}}');
        $this->dropIndex('IDX_fl_coin_id', '{{%forum_links}}');

        $this->dropForeignKey('IDX_fm_forum_id', '{{%forum_messages}}');
        $this->dropIndex('IDX_fm_forum_id', '{{%forum_messages}}');

        /*$this->dropForeignKey('IDX_post_coin_id', '{{%posts}}');
        $this->dropIndex('IDX_post_coin_id', '{{%posts}}');

        $this->dropForeignKey('IDX_post_site_id', '{{%posts}}');
        $this->dropIndex('IDX_post_site_id', '{{%posts}}');*/

        /*$this->dropForeignKey('IDX_post_created_by', '{{%posts}}');
        $this->dropIndex('IDX_post_created_by', '{{%posts}}');

        $this->dropForeignKey('IDX_post_updated_by', '{{%posts}}');
        $this->dropIndex('IDX_post_updated_by', '{{%posts}}');*/

        $this->dropForeignKey('IDX_handbook_coin_id', '{{%handbook}}');
        $this->dropIndex('IDX_handbook_coin_id', '{{%handbook}}');

        $this->dropForeignKey('IDX_handbook_created_by', '{{%handbook}}');
        $this->dropIndex('IDX_handbook_created_by', '{{%handbook}}');

        $this->dropForeignKey('IDX_handbook_updated_by', '{{%handbook}}');
        $this->dropIndex('IDX_handbook_updated_by', '{{%handbook}}');

        $this->dropPrimaryKey('PK-post_handbook_assignments', '{{%post_handbook_assignments}}');

        $this->dropForeignKey('IDX_ph_post_id', '{{%post_handbook_assignments}}');
        $this->dropIndex('IDX_ph_post_id', '{{%post_handbook_assignments}}');

        $this->dropForeignKey('IDX_ph_handbook_id', '{{%post_handbook_assignments}}');
        $this->dropIndex('IDX_ph_handbook_id', '{{%post_handbook_assignments}}');

        $this->dropForeignKey('IDX_vote_user_id', '{{%vote}}');
        $this->dropIndex('IDX_vote_user_id', '{{%vote}}');

        $this->dropForeignKey('IDX_vote_post_id', '{{%vote}}');
        $this->dropIndex('IDX_vote_post_id', '{{%vote}}');

        $this->dropForeignKey('IDX_saved_user_id', '{{%saved}}');
        $this->dropIndex('IDX_saved_user_id', '{{%saved}}');

        $this->dropForeignKey('IDX_saved_post_id', '{{%saved}}');
        $this->dropIndex('IDX_saved_post_id', '{{%saved}}');

        $this->dropForeignKey('IDX_fc_coin_id', '{{%duplicate}}');
        $this->dropIndex('IDX_fc_coin_id', '{{%duplicate}}');

        $this->dropForeignKey('IDX_coins_image', '{{%coins}}');
        $this->dropIndex('IDX_coins_image', '{{%coins}}');

        $this->dropTable('{{%landing_settings}}');

        $this->dropTable('{{%coupons}}');

        $this->dropTable('{{%formula}}');

        $this->dropTable('{{%landing_blocks}}');

        $this->dropTable('{{%settings_sites}}');

        $this->dropTable('{{%social_network}}');

        $this->dropTable('{{%landing_blocks_elements}}');

        $this->dropTable('{{%exchanges}}');

        $this->dropTable('{{%seo}}');

        $this->dropTable('{{%algorithm_encryption}}');

        $this->dropTable('{{%algorithm_consensus}}');

        $this->dropTable('{{%coins}}');

        $this->dropTable('{{%blog}}');

        $this->dropTable('{{%coin_price}}');

        $this->dropTable('{{%check_user}}');

        $this->dropTable('{{%favourites}}');

        $this->dropTable('{{%social_links}}');

        $this->dropTable('{{%invoice}}');

        $this->dropTable('{{%form}}');

        $this->dropTable('{{%forum_links}}');

        $this->dropTable('{{%forum_messages}}');

        $this->dropTable('{{%posts}}');

        $this->dropTable('{{%handbook}}');

        $this->dropTable('{{%post_handbook_assignments}}');

        $this->dropTable('{{%vote}}');

        $this->dropTable('{{%saved}}');

        $this->dropTable('{{%duplicate}}');

        $this->dropTable('{{%import}}');

        $this->dropTable('{{%pictures}}');
    }
}
