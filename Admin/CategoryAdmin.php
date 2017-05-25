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
use Mindy\Bundle\BlogBundle\Form\CategoryForm;
use Mindy\Bundle\BlogBundle\Model\Category;

class CategoryAdmin extends AbstractModelAdmin
{
    public $columns = ['name', 'slug'];

    public function getFormType()
    {
        return CategoryForm::class;
    }

    public function getModelClass()
    {
        return Category::class;
    }
}
