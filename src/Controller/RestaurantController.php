<?php

namespace App\Controller;

use App\DataFixtures\RestaurantFixtures;
use App\Entity\Restaurant;
use App\Entity\Comment;
use App\Entity\Avis;
use App\Form\AvisType;
use App\Form\CommentType;
use App\Form\RestaurantType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;




class RestaurantController extends AbstractController
{
    /**
     * @Route("/restaurant", name="restaurant")
     */
    public function index()
    {


        return $this->render('restaurant/index.html.twig', [
            'title' => 'Manger à Visé',

        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(RestaurantRepository $repo)
    {
        //$repo = $this->getDoctrine()->getRepository(Restaurant::class);

        $restaurants = $repo->findAll();


        return $this->render('restaurant/home.html.twig', [
            'restaurants' => $restaurants,

        ]);
    }

    /**
     * @Route("/gallery", name="gallery")
     */
    public function gallery()
    {
        $repo = $this->getDoctrine()->getRepository(Restaurant::class);

        $restaurants = $repo->findAll();


        return $this->render('restaurant/gallery.html.twig', [
            'restaurants' => $restaurants,

        ]);
    }

    /**
     * @Route("/restaurant/new",name="restaurant/create")
     * @Route("/restaurant/{id}/edit", name="restaurant/edit")
     */
    public function form(Restaurant $restaurant = null, Request $request, ObjectManager $manager, FileUploader $fileUploader)
    {
        if(!$restaurant) {
            $restaurant = new Restaurant();
        }

        //$form = $this->createFormBuilder($restaurant)
        //             ->add('titre')
        //             ->add('image')
        //             ->add('description')
        //             ->add('informations')
        //            ->add('avis')

        //             ->getForm();
        $image = $restaurant->getImage();
        $restaurant->setImage(null);
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if ($restaurant->getImage() !== null){
                $file = $restaurant->getImage();
                $fileName = $fileUploader->upload($file);
                $restaurant->setImage($fileName);
            }
            else{
                $restaurant->setImage($image);
            }
            $manager -> persist($restaurant);
            $manager -> flush();

            return $this->redirectToRoute('restaurant',['id' => $restaurant->getId()]);
        }

        return $this->render('restaurant/create.html.twig', [
            'formRestaurant' => $form->createView(),
            'editMode' => $restaurant->getId() !== null

            ]);
    }


    /**
     * @Route("/restaurant/{id}", name="restaurant")
     */


    public function restaurant(Restaurant $restaurant, Request $request, ObjectManager $manager)
    {
        //$repo = $this->getDoctrine()->getRepository(Restaurant::class);

        //$restaurant = $repo->find($id);

        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $avis->setCreatedAt(new \DateTime())
                 ->setRestaurant($restaurant);

            $manager->persist($avis);
            $manager->flush();

            return $this->redirectToRoute('restaurant',['id' => $restaurant->getId()
            ]);
        }

        return $this->render('restaurant/restaurant.html.twig', [
            'restaurant' => $restaurant,
            'avisForm' => $form->createView()

        ]);
    }
    /**
     * @Route("/reservation", name="reservation")
     */
    public function reservation()
    {
        return $this->render('restaurant/reservation.html.twig', [
            'title' => 'Manger à Visé',

        ]);
    }
    public function new(Request$request, FileUploader $fileUploader)
    {
      //  if($form->isSubmitted && $form->IsValid()){}


    }
}


