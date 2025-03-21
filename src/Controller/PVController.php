<?php

namespace App\Controller;

use App\Entity\PVVersion;
use App\Repository\PVVersionRepository;
use App\Service\PdfGeneratorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class PVController extends AbstractController
{
    #[Route('/pv/generate/{id}', name: 'app_pv_generate')]
    public function generate(int $id, PVVersionRepository $pvRepo, PdfGeneratorService $pdfService, EntityManagerInterface $em): Response
    {
        $pv = $pvRepo->find($id);
        if (!$pv) {
            throw $this->createNotFoundException("PV introuvable !");
        }

        $pdfContent = $pdfService->generatePdf('pv/pdf_template.html.twig', [
            'pv' => $pv
        ]);

        $filename = 'pv_recettage_' . $pv->getId() . '.pdf';
        $pv->setFilename($filename);
        $em->flush();

        return new StreamedResponse(function () use ($pdfContent) {
            echo $pdfContent;
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }
}
