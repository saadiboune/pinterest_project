<?php

namespace App\Controller;


use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{

    /**
     * @Route("/", name="app_home")
     * @param PinRepository $pinRepo
     * @return Response
     */
    public function index(/*EntityManagerInterface $em*/ PinRepository $pinRepo):Response
    {
//        $pin = new Pin();
//        $pin -> setTitle('Title 4');
//        $pin -> setDescription('description 4');
//
//        $em -> persist($pin);
//        $em -> flush();
//        $repo = $em -> getRepository(Pin::class);
//
//        $pins = $repo -> findAll();

//        return $this->render('pins/index.html.twig', ['pins' => $pins]);
        return $this->render('pins/index.html.twig', ['pins' => $pinRepo -> findAll()]);
    }

    /**
     * @Route("/pins/{id<\d+>}", name="app_pin_details")
     * @param Pin $pin
     * @return Response
     */
    public function getPin(Pin $pin): Response {
//        getPin(PinRepository $pinRepository, int $id)
//        $pin = $pinRepository -> find($id);
//        if(! $pin) {
//            throw $this -> createNotFoundException('Pin ' . $id . ' Not Found');
//        }
        return $this -> render('pins/pinDetails.html.twig', compact('pin'));
    }

    /**
     * @Route("/pins/create", name="app_pin_create", methods={"GET", "POST", "PATCH"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $em) {
//        if ($request -> isMethod('POST')) {
////            $data = $request->request -> all();
////            if ($this -> isCsrfTokenValid('pin_create', $data['_token'])) {
////                $pin = new Pin();
////                $pin -> setTitle($data['title']);
////                $pin -> setDescription($data['description']);
////                $em -> persist($pin);
////                $em -> flush();
////            }
////            return $this -> redirectToRoute('app_home');
////        }
        $pin = new Pin;
        $form = $this -> createFormBuilder($pin)
            -> add('title', null, [
                'attr' =>['autofocus' => true]])
            ->add('description', null, ['attr' => ['rows' => 10, 'cols' => 50]])
            -> getForm()
        ;
        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()) {
            $em -> persist($pin);
//            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('app_pin_details', ['id' => $pin -> getId()]);
        }
        return $this->render('pins/create.html.twig', [
            'pinForm' => $form -> createView()
        ]);
    }

}
