<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\BlogBundle\Model;

use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\SlugField;
use Mindy\Orm\TreeModel;

/**
 * Class Category
 *
 * @property string $name
 * @property string $slug
 */
class Category extends TreeModel
{
    public static function getFields()
    {
        return array_merge(parent::getFields(), [
            'name' => [
                'class' => CharField::class,
            ],
            'slug' => [
                'class' => SlugField::class,
            ],
        ]);
    }

    public function __toString()
    {
        return (string) $this->name;
    }
}
