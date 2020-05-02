<?php

namespace App\Controller\Admin;



use App\Entity\Option;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class AdminPropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @var ManagerRegistry
     */
    private $em;

    public function __construct(PropertyRepository $repository, ManagerRegistry $em)
    {
        $this->repository = $repository;
        $this->em = $em->getManager();
    }

    /**
     * @Route("/admin", name="admin.property.index")
     * @return Response
     */

    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', [
            'properties' => $properties
        ]);
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     * @param Request $request
     * @return Response
     */

    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success','Créer avec succes !');
            return $this->redirectToRoute("admin.property.index");
        }
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' =>$form->createView()
        ]);
    }

    /**
     * @Route("admin/property/{id}",name="admin.property.delete",methods={"DELETE"})
     * @param Property $property
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Property $property, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success','Supprimer avec succes !');
        }
        return $this->redirectToRoute('admin.property.index');
    }


    /**
     * @Route("/admin/property/{id}", name="admin.property.edit")
     * @param Property $property
     * @param Request $request
     * @param CacheManager $cachmanager
     * @param UploaderHelper $helper
     * @return Response
     */


    public function edit(Property $property, Request $request, CacheManager $cachmanager, UploaderHelper $helper)
    {

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($property->getImageFile() instanceof UploadedFile){
                $cachmanager->remove($helper->asset($property, 'imageFile'));
            }
            $this->em->flush();
            $this->addFlash('success','Modifier avec succes !');
            return $this->redirectToRoute("admin.property.index");

        }
        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' =>$form->createView()
        ]);
    }
}