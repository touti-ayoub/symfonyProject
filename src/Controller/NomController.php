<?php

namespace App\Controller;

use App\Entity\Reservation;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NomController extends AbstractController
{
    #[Route('/home', name: 'app_nom')]
    public function index(): Response
    {
        return $this->render('menu/menu.html.twig');
    }

    #[Route('/add', name: 'app_add')]
    public function add(Request $req ,ManagerRegistry $doctrine): Response
    {
        if ($req->isMethod("post")) {
            $res = new Reservation();
            $res->setName($req->get('name'));
            $res->setEmail($req->get('email'));
            $res->setPhone($req->get('phone'));
            $date_expire=$req->get('date')." ".$req->get('time');
            $date = new DateTime($date_expire);
            $res->setDate($date);
            $res->setTime($date);
            $res->setNbPeople($req->get('nb'));
            $res->setDescription($req->get('description'));
            $em=$doctrine->getManager();
            $em->persist($res);
            $em->flush();
            //return new Response("Inserted Successfully !!");
            //return $this->redirectToRoute("app_add");

        }
        return $this->render('menu/confirmation.html.twig');
    }
}
