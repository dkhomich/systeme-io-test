<?php

namespace App\Controller;

use App\Form\Model\TaxCalculatorFormModel;
use App\Form\TaxCalculatorFormType;
use App\Repository\TaxNumberPatternRepository;
use App\Service\TaxCalculatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaxCalculatorController extends AbstractController
{
    #[Route('/', name: 'app_tax_calculator_index', methods: ['get', 'post'])]
    public function index(
        Request $request,
        TaxCalculatorService $taxCalculatorService,
        TaxNumberPatternRepository $taxNumberPatternRepository,
    ): Response {
        $form = $this->createForm(TaxCalculatorFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var TaxCalculatorFormModel $formModel */
            $formModel = $form->getData();

            if ($matchingPattern = $taxNumberPatternRepository->getMatchedByTaxNumber($formModel->getTaxNumber())) {
                $taxAmount = $taxCalculatorService->calculate($formModel->getProduct(), $matchingPattern->getCountry());
                $formModel
                    ->setTaxAmount($taxAmount)
                    ->setCountry($matchingPattern->getCountry());
            }
        }


        return $this->render(
            'calculator/index.html.twig', [
                'calculatorForm' => $form,
                'calculationResult' => $formModel ?? null
            ]
        );
    }
}
