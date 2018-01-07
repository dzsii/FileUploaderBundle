<?php

// src/Thinkbig\Bundle/TuitionBundle/Model/GroupRepository.php
namespace Thinkbig\Bundle\FileUploaderBundle\Model;

use Thinkbig\Bundle\FileUploaderBundle\Entity\File;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\Criteria;

class FileRepository extends EntityRepository
{

    public function getOwnedFiles($owner, $mapping) {

        return $this->getEntityManager()->createQuery(
            'SELECT file FROM Thinkbig\Bundle\FileUploaderBundle:File file WHERE file.Owner IN(:owner) AND file.mapping IN (:mapping) ORDER BY file.id DESC'
        )
        ->setParameter('owner', $owner)
        ->setParameter('mapping', $mapping)
        ->getResult();

    }

    public function getLatestOwnedFile($owner, $mapping) {

        return $this->getEntityManager()->createQuery(
            'SELECT file FROM Thinkbig\Bundle\FileUploaderBundle:File file WHERE file.Owner = :owner AND file.mapping = :mapping ORDER BY file.id DESC'
        )
        ->setParameter('owner', $owner)
        ->setParameter('mapping', $mapping)
        ->setMaxResults(1)
        ->setFirstResult(0)
        ->getOneOrNullResult();

    }

}