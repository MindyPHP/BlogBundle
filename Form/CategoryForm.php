<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\BlogBundle\Form;

use Mindy\Bundle\BlogBundle\Model\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $instance = $builder->getData();

        $builder
            ->add('parent', ChoiceType::class, [
                'required' => false,
                'choices' => Category::objects()->order(['root', 'lft'])->all(),
                'choice_attr' => function ($category, $key, $index) use ($instance) {
                    return [
                        'disabled' => $category->pk == $instance->pk,
                    ];
                },
                'choice_value' => 'id',
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
            ]);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            dump($data);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
