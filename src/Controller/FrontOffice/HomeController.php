<?php

namespace App\Controller\FrontOffice;

use App\Repository\FormationRepository;
use App\Repository\ReferenceRepository;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller\FrontOffice
 * @Route("/", name="home")
 */
class HomeController extends AbstractController
{
    /**
     * @param FormationRepository $formationRepository
     * @param $skillRepository
     * @return Response
     */
    public function __invoke(FormationRepository $formationRepository, SkillRepository $skillRepository, ReferenceRepository $referenceRepository): Response
    {
        $formations = $formationRepository->findAll();
        $skills = $skillRepository->findAll();
        $references = $referenceRepository->findAll();

        return $this->render("front_office/home.html.twig", [
            "formations" => $formations,
            "skills" => $skills,
            "references" => $references
        ]);
    }
}
