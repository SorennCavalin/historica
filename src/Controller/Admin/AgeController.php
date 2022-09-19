<?php

namespace App\Controller\Admin;

use App\Entity\Age;
use App\Form\AgeType;
use App\Repository\AgeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/age')]
class AgeController extends AbstractController
{
    #[Route('/', name: 'app_admin_age_index', methods: ['GET'])]
    public function index(AgeRepository $ageRepository): Response
    {
        return $this->render('admin/age/index.html.twig', [
            'ages' => $ageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_age_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AgeRepository $ageRepository): Response
    {
        $age = new Age();
        $form = $this->createForm(AgeType::class, $age);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ageRepository->add($age, true);

            return $this->redirectToRoute('app_admin_age_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/age/new.html.twig', [
            'age' => $age,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_age_show', methods: ['GET'])]
    public function show(Age $age): Response
    {
        return $this->render('admin/age/show.html.twig', [
            'age' => $age,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_age_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Age $age, AgeRepository $ageRepository): Response
    {
        $form = $this->createForm(AgeType::class, $age);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ageRepository->add($age, true);

            return $this->redirectToRoute('app_admin_age_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/age/edit.html.twig', [
            'age' => $age,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_age_delete', methods: ['POST'])]
    public function delete(Request $request, Age $age, AgeRepository $ageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$age->getId(), $request->request->get('_token'))) {
            $ageRepository->remove($age, true);
        }

        return $this->redirectToRoute('app_admin_age_index', [], Response::HTTP_SEE_OTHER);
    }
}
