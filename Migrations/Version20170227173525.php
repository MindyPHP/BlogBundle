<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\BlogBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Mindy\Bundle\BlogBundle\Model\Category;
use Mindy\Bundle\BlogBundle\Model\Post;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170227173525 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $categoryTable = $schema->createTable(Category::tableName());
        $categoryTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $categoryTable->addColumn('parent_id', 'integer', ['length' => 11, 'notnull' => false]);
        $categoryTable->addColumn('lft', 'integer', ['length' => 11]);
        $categoryTable->addColumn('rgt', 'integer', ['length' => 11]);
        $categoryTable->addColumn('level', 'integer', ['length' => 11]);
        $categoryTable->addColumn('root', 'integer', ['length' => 11, 'notnull' => false]);
        $categoryTable->addColumn('name', 'string', ['length' => 255]);
        $categoryTable->addColumn('slug', 'string', ['length' => 255]);
        $categoryTable->setPrimaryKey(['id']);

        $postTable = $schema->createTable(Post::tableName());
        $postTable->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $postTable->addColumn('category_id', 'integer', ['length' => 11, 'notnull' => false]);
        $postTable->addColumn('is_published', 'smallint', ['length' => 1, 'default' => 0]);
        $postTable->addColumn('content', 'text');
        $postTable->addColumn('content_short', 'text');
        $postTable->addColumn('image', 'text');
        $postTable->addColumn('created_at', 'datetime');
        $postTable->addColumn('updated_at', 'datetime', ['notnull' => false]);
        $postTable->addColumn('published_at', 'datetime', ['notnull' => false]);
        $postTable->addColumn('name', 'string', ['length' => 255]);
        $postTable->addColumn('slug', 'string', ['length' => 255]);
        $postTable->setPrimaryKey(['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable(Post::tableName());
        $schema->dropTable(Category::tableName());
    }
}
