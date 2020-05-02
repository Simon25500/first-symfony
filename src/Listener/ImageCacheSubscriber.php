<?php

namespace App\Listener;



use App\Entity\Property;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber {


    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var UploaderHelper
     */
    private $uploaderHelper;

    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {

        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    public function preRemove(LifecycleEventArgs $args) {
        if (!$args->getEntity() instanceof Property){
            return;
        }
            $this->cacheManager->remove($this->uploaderHelper->asset($args->getEntity(), 'imageFile'));
    }

    public function preUpdate(PreUpdateEventArgs $args) {
        if (!$args->getEntity() instanceof Property){
            return;
        }
        if ($args->getEntity()->getImageFile() instanceof UploadedFile) {
            $this->cacheManager->remove($this->uploaderHelper->asset($args->getEntity(), 'imageFile'));
        }
    }
}