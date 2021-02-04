<?php

namespace App\Controller\BackOffice;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SkillController
 * @package App\Controller\BackOffice
 * @Route("/admin/skills")
 */
class SkillController extends AbstractController
{
    /**
     * @Route(name="skill_index")
     * @param SkillRepository $skillRepository
     * @return Response
     */
    public function index(SkillRepository $skillRepository): Response
    {
        $skills = $skillRepository->findAll();

        return $this->render("back_office/skill/index.html.twig", [
            "skills" => $skills
        ]);
    }

    /**
     * @Route("/new", name="skill_new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($skill);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "La compétence a été ajoutée avec succès !");

            return $this->redirectToRoute("skill_index");
        }

        return $this->render("back_office/skill/new.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="skill_edit")
     * @param Skill $skill
     * @param Request $request
     * @return Response
     */
    public function edit(Skill $skill, Request $request): Response
    {
        $form = $this->createForm(SkillType::class, $skill)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "La compétence a été modifiée avec succès !");

            return $this->redirectToRoute("skill_index");
        }

        return $this->render("back_office/skill/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/delete", name="skill_delete")
     * @param Skill $skill
     * @return RedirectResponse
     */
    public function delete(Skill $skill): RedirectResponse
    {
        $this->getDoctrine()->getManager()->remove($skill);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash("success", "La compétence a été supprimée avec succès !");

        return $this->redirectToRoute("skill_index");
    }
}
