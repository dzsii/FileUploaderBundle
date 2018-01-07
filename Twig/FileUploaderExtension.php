<?php

// src/AppBundle/Twig/AppExtension.php
namespace Thinkbig\Bundle\FileUploaderBundle\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Doctrine\ORM\EntityManager;
use League\Flysystem\MountManager;
use Intervention\Image\ImageManager;

use Thinkbig\Bundle\FileUploaderBundle\Entity\File;

class FileUploaderExtension extends \Twig_Extension
{

	private $entityManager;
	private $mountManager;
	private $router;

	public function __construct(EntityManager $entityManager, Router $router, MountManager $mountManager)
	{


        $this->imageManager 	= new ImageManager(array('driver' => 'imagick'));

		$this->entityManager 	= $entityManager;
		$this->mountManager 	= $mountManager;
		$this->router 			= $router;
	
	}

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('download', 				[$this, 'downloadFilter']),
            new \Twig_SimpleFilter('inline',                [$this, 'inlineFilter']),
            new \Twig_SimpleFilter('base64image', 			[$this, 'base64Filter']),
        //    new \Twig_SimpleFunction('base64image', 	[$this, 'base64Function'])
        );
    }

    public function getTests()
    {
        return [
            'instanceof' =>  new \Twig_SimpleTest('instanceof', array($this, 'isInstanceOf'))
        ];
    }

    public function downloadFilter($file)
    {

    	if (is_int($file)) {

    		$file = $this->entityManager->getRepository('Thinkbig\Bundle\FileUploaderBundle\Entity\File')->find($file);

    	}

    	$url = $this->router->generate(
		    'thinkbig_file_uploader_download',
		    array(
		    	'file' => $file->getId(),
		    	'ext'  => $file->getOriginalExtension()
			),
		    UrlGeneratorInterface::ABSOLUTE_URL // This guy right here
		);

		return $url;

    }

    public function inlineFilter($file)
    {

        if (is_int($file)) {

            $file = $this->entityManager->getRepository('Thinkbig\Bundle\FileUploaderBundle\Entity\File')->find($file);

        }

        $url = $this->router->generate(
            'thinkbig_file_uploader_download',
            array(
                'file'          => $file->getId(),
                'ext'           => $file->getOriginalExtension(),
                'disposition'   => 'inline'
            ),
            UrlGeneratorInterface::ABSOLUTE_URL // This guy right here
        );

        return $url;

    }

    public function base64Filter($file) {

    	if (is_int($file)) {

    		$file = $this->entityManager->getRepository('Thinkbig\Bundle\FileUploaderBundle\Entity\File')->find($file);

    	}

    	if (!$file instanceof File) {

    		throw new \Exception("Error Processing file", 1);
    		
    	} 

        if ($file->getExtension() == 'pdf') {


            $data   = $this->mountManager->read('web://assets/img/img-error.png');


        }
        else {

            $data   = $this->mountManager->read(sprintf('local://%s', $file->getAdapterPath()));

        }

    	

		$img 	= $this->imageManager->make($data);

		$img->fit(500, 500);

		return $img->encode('data-url');


    }


    /**
     * @param $var
     * @param $instance
     * @return bool
     */
    public function isInstanceof($var, $instance) {
        return  $var instanceof $instance;
    }

}