<?php

namespace Thinkbig\Bundle\FileUploaderBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Thinkbig\Bundle\FileUploaderBundle\Entity\File;
use Thinkbig\Bundle\FileUploaderBundle\Form\DataTransformer\FileToIdTransformer;


use Oneup\UploaderBundle\Templating\Helper\UploaderHelper;

class UploadedFileType extends AbstractType
{

    private $transformer;
    private $helper;

    public function __construct(FileToIdTransformer $transformer, UploaderHelper $helper)
    {
        $this->transformer  = $transformer;
        $this->helper       = $helper;

    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', HiddenType::class, [ 
            'attr'              => array(
                'data-form-type'        => 'file_uploader',
                'data-form-endpoint'    => $this->helper->endpoint('documents'),
                'data-form-owner'       => null
            )

            ]);

        $builder->get('file')->addModelTransformer($this->transformer);
    }

}
