<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\Repository\ContactRepository;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/records", name="records")
     * @Route("/records/new", name="new_records", defaults={"new"=true})
     *
     * @param Request $request
     * @param boolean $new
     * @return Response
     * @throws \RuntimeException
     */
    public function indexAction(Request $request, $new = false)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        $paginator = $this->get('knp_paginator');
        try {
            $pagination = $paginator->paginate(
                $em->getRepository(Contact::class)->findAllRecords($new),
                $request->query->getInt('page', 1),
                1
            );
        } catch (ORMException $exception) {
            throw new \RuntimeException($exception->getMessage());
        }	

	$total_pages = $pagination->getTotalItemCount();
	$uuid = $pagination->getitems('id');
	$uuid = $uuid[0]->getId();	
	$responce = $em->getRepository(Contact::class)->updateIsRead($uuid);
	if($responce == "true"){
	    $pagination->setTotalItemCount($total_pages -1);
	}
	
        return $this->render('@App/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/record/{uuid}", name="view_record")
     *
     * @param string $uuid
     * @return Response
     */
    public function loadRecordAction($uuid)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        try {
            $record = $em->getRepository(Contact::class)->loadRecord($uuid);
        } catch (ORMException $exception) {
            throw new \RuntimeException($exception->getMessage());
        }

	$em->getRepository(Contact::class)->updateIsRead($uuid);

        return $this->render('@App/view.html.twig', [
            'record' => $record,
        ]);
    }
}
