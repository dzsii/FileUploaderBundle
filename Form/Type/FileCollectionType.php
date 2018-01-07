<?php

namespace Thinkbig\Bundle\FileUploaderBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Thinkbig\Bundle\FileUploaderBundle\Form\Type\UploadedFileType;

class FileCollectionType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        
        $resolver->setDefaults(array(
            'entry_type'        => UploadedFileType::class, 
            'entry_options'     => array('label' => false),
            'allow_add'         => true,
            'allow_delete'      => true,
            'prototype'         => true,
            'mapped'            => false,
            'label'             => false,
            'attr'              => array(
                'data-form-type'        => 'file_collection',
                'data-form-endpoint'    => null,
                'data-form-owner'       => null
            )
        ));

    }

    public function getParent()
    {
        return CollectionType::class;
    }

    public function getName()
    {
        return 'file_collection';
    }
}
