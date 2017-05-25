<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\BlogBundle\Admin;

use Mindy\Bundle\AdminBundle\Admin\AbstractModelAdmin;
use Mindy\Bundle\BlogBundle\Form\PostForm;
use Mindy\Bundle\BlogBundle\Model\Post;

class PostAdmin extends AbstractModelAdmin
{
    public $columns = ['name', 'slug', 'created_at'];

    /**
     * @return string model class name
     */
    public function getModelClass()
    {
        return Post::class;
    }

    public function getFormType()
    {
        return PostForm::class;
    }
}
