<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\BlogBundle\Model;

use Mindy\Bundle\CommentBundle\Comment\CommentOwnerInterface;
use Mindy\Bundle\CommentBundle\Comment\CommentOwnerTrait;
use Mindy\Bundle\RatingBundle\Rating\RatingOwnerInterface;
use Mindy\Bundle\RatingBundle\Rating\RatingOwnerTrait;
use Mindy\Bundle\UserBundle\Model\User;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Fields\SlugField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;

/**
 * Class Post.
 *
 * @method static PostManager objects($instance = null)
 *
 * @property string $name
 * @property string $slug
 * @property string $content
 * @property string $content_short
 * @property string $image
 * @property int|bool $is_published
 * @property string|\DateTime $created_at
 * @property string|\DateTime|null $updated_at
 * @property string|\DateTime|null $published_at
 * @property int $category_id
 * @property Category $category
 */
class Post extends Model implements CommentOwnerInterface, RatingOwnerInterface
{
    use RatingOwnerTrait;
    use CommentOwnerTrait;

    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
            ],
            'slug' => [
                'class' => SlugField::class,
            ],
            'is_published' => [
                'class' => BooleanField::class,
                'default' => false,
            ],
            'content' => [
                'class' => TextField::class,
            ],
            'content_short' => [
                'class' => TextField::class,
            ],
            'image' => [
                'class' => ImageField::class,
                'null' => true,
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'autoNowAdd' => true,
            ],
            'updated_at' => [
                'class' => DateTimeField::class,
                'autoNow' => true,
            ],
            'published_at' => [
                'class' => DateTimeField::class,
                'null' => true,
            ],
            'category' => [
                'class' => ForeignField::class,
                'modelClass' => Category::class,
                'null' => true,
            ],
            'author' => [
                'class' => ForeignField::class,
                'modelClass' => User::class,
                'null' => true,
            ],
        ];
    }

    public function __toString()
    {
        return (string) $this->name;
    }

    /**
     * @return string
     */
    public function getObjectType()
    {
        return 'blog_post';
    }

    /**
     * @return int|string
     */
    public function getObjectId()
    {
        return $this->id;
    }
}
