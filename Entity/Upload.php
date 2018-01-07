<?php

// src/Thinkbig\Bundle/TuitionBundle/Entity/Course.php
namespace Thinkbig\Bundle\FileUploaderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Table(name="ThinkbigFileUploaderBundle_Upload")
 * @ORM\Entity()
 */
class Upload
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPrivate;

    /**
     * @ORM\ManyToOne(targetEntity="ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping")
     */
    private $Uploader;

    /**
     * @ORM\ManyToOne(targetEntity="ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping")
     */
    private $Target;

    /**
     * @ORM\OneToMany(targetEntity="Thinkbig\Bundle\FileUploaderBundle\Entity\File", mappedBy="Upload", cascade={"persist"})
     */
    private $Files;

    
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Files = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set isPrivate
     *
     * @param boolean $isPrivate
     *
     * @return Upload
     */
    public function setIsPrivate($isPrivate)
    {
        $this->isPrivate = $isPrivate;

        return $this;
    }

    /**
     * Get isPrivate
     *
     * @return boolean
     */
    public function getIsPrivate()
    {
        return $this->isPrivate;
    }

    /**
     * Set uploader
     *
     * @param \ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping $uploader
     *
     * @return Upload
     */
    public function setUploader(\ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping $uploader = null)
    {
        $this->Uploader = $uploader;

        return $this;
    }

    /**
     * Get uploader
     *
     * @return \ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping
     */
    public function getUploader()
    {
        return $this->Uploader;
    }

    /**
     * Set target
     *
     * @param \ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping $target
     *
     * @return Upload
     */
    public function setTarget(\ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping $target = null)
    {
        $this->Target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return \ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping
     */
    public function getTarget()
    {
        return $this->Target;
    }

    /**
     * Add file
     *
     * @param \Thinkbig\Bundle\FileUploaderBundle\Entity\File $file
     *
     * @return Upload
     */
    public function addFile(\Thinkbig\Bundle\FileUploaderBundle\Entity\File $file)
    {
        $this->Files[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param \Thinkbig\Bundle\FileUploaderBundle\Entity\File $file
     */
    public function removeFile(\Thinkbig\Bundle\FileUploaderBundle\Entity\File $file)
    {
        $this->Files->removeElement($file);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->Files;
    }
}
