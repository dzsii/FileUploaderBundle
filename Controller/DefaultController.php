<?php

namespace Thinkbig\Bundle\FileUploaderBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use Thinkbig\Bundle\FileUploaderBundle\Form\Type\UploadedFileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Thinkbig\Bundle\FileUploaderBundle\Entity\File;

use Intervention\Image\ImageManager;

class DefaultController extends Controller
{
    public function indexAction()
    {

    	$form = $this->createFormBuilder([])
            ->add('file', UploadedFileType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Post'))
            ->getForm();

        return $this->render('ThinkbigFileUploaderBundle:Default:index.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/img/{method}/{dimension}/{image}.{ext}", name="Image:show")
     */
    public function showAction(Request $request, File $image, $method, $dimension, $ext)
    {

        $filesystem         = $this->get('oneup_flysystem.mount_manager')->getFilesystem('local');

        if ($filesystem->has($image->getAdapterPath())) {

            $manager = new ImageManager(array('driver' => 'imagick'));

            $img = $manager->make($filesystem->read($image->getAdapterPath()));
            
            if (strpos($dimension, ':') === false) {
            
                $width  = $dimension;
                $height = $dimension;
            
            }
            else {
            
                list($width, $height) = explode(':', $dimension);
            
            }
            
            switch (true) {
                case $method == 'fill':
                    
                    $img->fit($width, $height);
                    
                    break;
                case $method == 'widen':
                case ($img->width()/$img->height() > $width/$height && $method == 'fit'):
                    
                    $img->widen($width);

                    break;
                case $method == 'heighten':
                case ($img->width()/$img->height() <= $width/$height && $method == 'fit'):
                    
                    $img->heighten($height);
                    
                    break;
            }

            $jpg = (string) $img->encode('jpg', 100);
            $response = new Response($jpg);
            $d = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_INLINE,
                'img.jpg'
            );
            $response->headers->set('Content-Type', 'image/jpg');
            $response->headers->set('Content-Disposition', $d);
            return $response;

        }

        return new Response('Error opening image');

    }


    public function downloadAction(Request $request, File $file, $ext)
    {

        $disposition = $request->query->get('disposition', ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        $filesystem         = $this->get('oneup_flysystem.mount_manager')->getFilesystem('local');

        if ($filesystem->has($file->getAdapterPath())) {
            
            $path = $filesystem->getAdapter()->applyPathPrefix($file->getAdapterPath());

            return $this->file($path, $file->getOriginalFileName(), $disposition);

        }

        return new Response('Error opening file');

    }
}
