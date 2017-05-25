<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\BlogBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Mindy\Bundle\BlogBundle\Model\Category;
use Mindy\Bundle\BlogBundle\Model\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $instance = $builder->getData();

        $builder
            ->add('category', ChoiceType::class, [
                'required' => false,
                'choices' => Category::objects()->order(['root', 'lft'])->all(),
                'choice_value' => 'id',
                'choice_attr' => function ($category, $key, $index) use ($instance) {
                    return [
                        'selected' => $category->pk == $instance->category_id,
                    ];
                },
                'choice_label' => function ($category, $key, $index) {
                    /* @var Category $category */
                    return (string) str_repeat('...', $category->level - 1).' '.$category;
                },
            ])
            ->add('name', TextType::class)
            ->add('slug', TextType::class, [
                'attr' => [
                    'autofocus' => true,
                ],
            ])
            ->add('content', CKEditorType::class, [
                'required' => false,
                'config_name' => 'default',
            ])
            ->add('is_published', CheckboxType::class);

        $builder->get('is_published')->addModelTransformer(new CallbackTransformer(
            function ($value) {
                return (bool) $value;
            },
            function ($value) {
                return (string) $value;
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
