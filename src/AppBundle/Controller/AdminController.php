<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
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

        return $this->render('@App/view.html.twig', [
            'record' => $record,
        ]);
    }
}