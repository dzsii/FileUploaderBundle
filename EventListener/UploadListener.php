<?php

namespace Thinkbig\Bundle\FileUploaderBundle\EventListener;

use Doctrine\Common\Util\ClassUtils;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\HttpFoundation\File\Exception\UploadException;

use Oneup\UploaderBundle\Event\PostPersistEvent;

use Thinkbig\Bundle\FileUploaderBundle\Entity\File;
use ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping;
use Thinkbig\Bundle\FileUploaderBundle\Form\Type\FileCollectionType;

use Psr\Log\LoggerInterface;

class UploadListener
{
    /**
     * @var ObjectManager
     */
    private $entityManager;

    public function __construct(ObjectManager $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;

        $this->logger = $logger;
    }
    
    public function onUpload(PostPersistEvent $event)
    {

        $upload     = $event->getRequest()->files->get('file');
        $file       = $event->getFile();

    	$entity = new File();

    	$entity->setFileName($file->getBasename());
    	$entity->setExtension($file->getExtension());
    	$entity->setAdapterPath($file->getPathname());

        //$entity->setMimeType($upload->getMimeType());
        $entity->setOriginalFileName($upload->getClientOriginalName());
        $entity->setOriginalExtension($upload->getClientOriginalExtension());
        $entity->setOriginalFileSize($upload->getClientSize());

    	$entity->setAdapter('local'); 

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        

        $mapping    = new Mapping();
        
        $mapping->setObjectClass(ClassUtils::getClass($entity));
        $mapping->setObjectId($entity->getId());

        $this->entityManager->persist($mapping);

        $this->entityManager->flush();
        
        //if everything went fine
        $response = $event->getResponse();
        //$response['success'] = true;

        $response['fileName'] = $entity->getId();

        //return $response;
    }
}