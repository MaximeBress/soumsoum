<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
    /**
     * @Route("/", name="front_homepage")
     */
    public function indexAction()
    {
        return $this->render('front/index.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm('AppBundle\Form\ContactType',null,array(
            'action' => $this->generateUrl('contact'),
            'method' => 'POST'
        ));

        if ($request->isMethod('POST')) {
            // Refill the fields in case the form is not valid.
            $form->handleRequest($request);

            if($form->isValid()){
                // Send mail
                if($this->sendEmail($form->getData())){

                    // Everything OK, redirect to wherever you want ! :

                    return $this->redirectToRoute('contact');
                }else{
                    // An error ocurred, handle
                    var_dump("Errooooor :(");
                }
            }
        }

        return $this->render('front/contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
    private function sendEmail($data){
        $contactMail = $this->container->getParameter('mailer_user');;
        $contactPassword = $this->container->getParameter('mailer_password');;

        // In this case we'll use the ZOHO mail services.
        // If your service is another, then read the following article to know which smpt code to use and which port
        // http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
        // $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
        //     ->setUsername($contactMail)
        //     ->setPassword($contactPassword);
        //
        // $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance("Our Code World Contact Form ")
        ->setFrom(array($contactMail => "Message by ".$data["name"]))
        ->setTo(array(
            $contactMail => $contactMail
        ))
        ->setBody($data["message"]."<br>ContactMail :".$data["email"]);

        return $this->get('mailer')->send($message);
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction()
    {
        return $this->render('front/about.html.twig', array(
            // ...
        ));
    }

}
