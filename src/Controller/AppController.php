<?php

namespace App\Controller;

use Adaptive\Diff\Diff;
use Adaptive\Diff\Renderer\Html\SideBySide;
use App\Kernel;
use App\Repository\TranscriptRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{

    /**
     * @Route("/", name="transcript_index", methods={"GET"})
     */
    public function index(TranscriptRepository $transcriptRepository): Response
    {
        return $this->render('app/index.html.twig', [
            'transcripts' => $transcriptRepository->findAll(),
        ]);
    }

}
