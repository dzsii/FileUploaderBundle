<?php

// src/Thinkbig\Bundle\FileUploaderBundle/Form/DataTransformer/FileToNumberTransformer.php
namespace Thinkbig\Bundle\FileUploaderBundle\Form\DataTransformer;

use Thinkbig\Bundle\FileUploaderBundle\Entity\File;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FileToIdTransformer implements DataTransformerInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Transforms an object (file) to a string (number).
     *
     * @param  File|null $file
     * @return string
     */
    public function transform($file)
    {
        if (null === $file) {
            return '';
        }

        if (is_array($file) && count($file) == 1 && is_int($file[0])) {

            return $file[0];
        }

        return $file->getId();
    }

    /**
     * Transforms a string (number) to an object (file).
     *
     * @param  string $id
     * @return File|null
     * @throws TransformationFailedException if object (file) is not found.
     */
    public function reverseTransform($id)
    {
        // no file number? It's optional, so that's ok
        if (!$id) {
            return;
        }

        $file = $this->em->getRepository('ThinkbigFileUploaderBundle:File')->find($id)
        ;

        if (null === $file) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An file with number "%s" does not exist!',
                $id
            ));
        }

        return $file;
    }
}