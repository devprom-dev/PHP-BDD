<?php

namespace PHPBDD\PosterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class);
        $builder->add('blog', TextareaType::class);
        $builder->add('image', FileType::class);
        $builder->add('tags', TextType::class);
    }

    public function getBlockPrefix()
    {
        return 'post';
    }
}

