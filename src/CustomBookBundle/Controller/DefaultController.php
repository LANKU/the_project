<?php

namespace CustomBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @Route("/pdf", name="custom_pdf")
     */

    public function pdfAction(Request $request)

    {

        $em = $this->getDoctrine()->getManager();

        $books = $em->getRepository('CustomBookBundle:Book')->findAll();

        $snappy = $this->get('knp_snappy.pdf');

        $html = $this->render('CustomBookBundle:Default:index.html.twig', array(
            'books' => $books,
        ));

        $filename = 'SnappyPDF';

        return new Response(

            $snappy->getOutputFromHtml($html),200,array(

                'Content-Type'          => 'application/pdf',

                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'

            )

        );

    }

}
