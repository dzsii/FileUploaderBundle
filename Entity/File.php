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
 * @ORM\Table(name="ThinkbigFileUploaderBundle_File")
 * @ORM\Entity(repositoryClass="Thinkbig\Bundle\FileUploaderBundle\Model\FileRepository")
 */
class File implements \JsonSerializable
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $adapter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adapterPath;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fileName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $extension;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $width;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $height;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $originalFileName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $originalExtension;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $originalFileSize;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mimeType;

    /**
     * @ORM\ManyToOne(targetEntity="ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping")
     */
    private $Owner;


    /**
     * @ORM\ManyToOne(targetEntity="Thinkbig\Bundle\FileUploaderBundle\Entity\Upload", inversedBy="Files", cascade={"persist"})
     */
    private $Upload;

    
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

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
     * Set adapter
     *
     * @param string $adapter
     *
     * @return File
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * Get adapter
     *
     * @return string
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return File
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set adapterPath
     *
     * @param string $adapterPath
     *
     * @return File
     */
    public function setAdapterPath($adapterPath)
    {
        $this->adapterPath = $adapterPath;

        return $this;
    }

    /**
     * Get adapterPath
     *
     * @return string
     */
    public function getAdapterPath()
    {
        return $this->adapterPath;
    }



    /**
     * Set extension
     *
     * @param string $extension
     *
     * @return File
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Get organization
     *
     * @return \AppBundle\Entity\Organization
     */
    public function getOrganization()
    {
        return $this->Organization;
    }


    /**
     * Get folder
     *
     * @return \Thinkbig\Bundle\FileUploaderBundle\Entity\Folder
     */
    public function getFolder()
    {
        return $this->Folder;
    }

    /**
     * Set originalFileName
     *
     * @param string $originalFileName
     *
     * @return File
     */
    public function setOriginalFileName($originalFileName)
    {
        $this->originalFileName = $originalFileName;

        return $this;
    }

    /**
     * Get originalFileName
     *
     * @return string
     */
    public function getOriginalFileName()
    {
        return $this->originalFileName;
    }

    /**
     * Set originalExtension
     *
     * @param string $originalExtension
     *
     * @return File
     */
    public function setOriginalExtension($originalExtension)
    {
        $this->originalExtension = $originalExtension;

        return $this;
    }

    /**
     * Get originalExtension
     *
     * @return string
     */
    public function getOriginalExtension()
    {
        return $this->originalExtension;
    }

    /**
     * Set originalFileSize
     *
     * @param string $originalFileSize
     *
     * @return File
     */
    public function setOriginalFileSize($originalFileSize)
    {
        $this->originalFileSize = $originalFileSize;

        return $this;
    }

    /**
     * Get originalFileSize
     *
     * @return string
     */
    public function getOriginalFileSize()
    {
        return $this->originalFileSize;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     *
     * @return File
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set owner
     *
     * @param \ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping $owner
     *
     * @return Folder
     */
    public function setOwner(\ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping $owner = null)
    {
        $this->Owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \ThinkBig\Bundle\EntityTransformBundle\Entity\Mapping
     */
    public function getOwner()
    {
        return $this->Owner;
    }

    /**
     * Set width
     *
     * @param integer $width
     *
     * @return File
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     *
     * @return File
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set upload
     *
     * @param \Thinkbig\Bundle\FileUploaderBundle\Entity\Upload $upload
     *
     * @return File
     */
    public function setUpload(\Thinkbig\Bundle\FileUploaderBundle\Entity\Upload $upload = null)
    {
        $this->Upload = $upload;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getUpload()
    {
        return $this->Upload;
    }

    public function __toString() {

        return $this->id;

    }

    public function jsonSerialize() {

        return array(
            $this->id
        );

    }
}
