<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\Type\ContactFormType;
use AppBundle\Lib\Utility;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        try {
            $formModel = new Contact();
        } catch (\Exception $exception) {
            throw new \RuntimeException('an error occurred');
        }
        $form = $this->createForm(ContactFormType::class, $formModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em      = $this->getDoctrine()->getManager();
            $contact = $form->getData();
            $em->persist($contact);
            $em->flush();

            return new JsonResponse([
                'status' => 'ok',
            ]);
        } elseif ($form->isSubmitted()) {
            return new JsonResponse([
                'status'   => 'error',
                'errors'   => Utility::getErrorsFromForm($form),
            ]);
        }

        return $this->render('@App/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
