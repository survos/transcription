<?php

namespace App\Controller;

use Adaptive\Diff\Diff;
use Adaptive\Diff\Renderer\Html\Inline;
use Adaptive\Diff\Renderer\Html\SideBySide;
use Adaptive\Diff\Renderer\Text\Context;
use App\Entity\Transcript;
use App\Form\TranscriptType;
use App\Repository\TranscriptRepository;
use SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

use SebastianBergmann\Diff\Differ;
use SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/transcript")
 */
class TranscriptController extends AbstractController
{
    /**
     * @Route("/", name="transcript_index", methods={"GET"})
     */
    public function index(TranscriptRepository $transcriptRepository): Response
    {
        return $this->render('transcript/index.html.twig', [
            'transcripts' => $transcriptRepository->findAll(),
        ]);
    }


    /**
     * @Route("/test", name="test")
     */
    public function test(KernelInterface $kernel)
    {

        $options = array(
            //'ignoreWhitespace' => true,
            //'ignoreCase' => true,
        );
        $some_file_path = $kernel->getProjectDir() . '/src/Controller/AppController.php';
        $some_other_file_path = $kernel->getProjectDir() . '/src/Controller/App2Controller.php';


        $a = explode("\n", $x=file_get_contents($some_file_path));
        $b = explode("\n", $y=file_get_contents($some_other_file_path));


        $builder = new StrictUnifiedDiffOutputBuilder([
            'collapseRanges'      => true, // ranges of length one are rendered with the trailing `,1`
            'commonLineThreshold' => 6,    // number of same lines before ending a new hunk and creating a new one (if needed)
            'contextLines'        => 3,    // like `diff:  -u, -U NUM, --unified[=NUM]`, for patch/git apply compatibility best to keep at least @ 3
            'fromFile'            => '',
            'fromFileDate'        => null,
            'toFile'              => '',
            'toFileDate'          => null,
        ]);
        $differ = new Differ($builder);
//        print '<pre>' .  $differ->diff($x, $y) . '</pre>';



        $diff = new Diff($a, $b, $options);
        $renderer = new SideBySide();

        // echo $diff->Render($renderer);

        return $this->render('app/test.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    /**
     * @Route("/new", name="transcript_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $transcript = new Transcript();
        $form = $this->createForm(TranscriptType::class, $transcript);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($transcript);
            $entityManager->flush();

            return $this->redirectToRoute('transcript_index');
        }

        return $this->render('transcript/new.html.twig', [
            'transcript' => $transcript,
            'form' => $form->createView(),
        ]);
    }




    private function split($text)  {
        $delim = ".";
        $length = 565;
        $length = 665;
        // $text = utf8_encode($text);

        dump(substr($text, $length, 100));
        $text = mb_substr($text, 0, $length);
        $x = array_map(function ($text) {
            $text = preg_replace('/  +/', ' ', $text);
            // hack for certain chars!
            $text = preg_replace('/(¿|»|«|…)/', '', $text);
            $text = preg_replace('/¿/', '', $text);
            $text = preg_replace('/,/', ',', $text);
            // $text = preg_replace('/í/', 'i', $text);
            return trim($text) . ".\n";
        }, preg_split("/(\.|\?)\W+/", $text) );
        // $x = join("\n", $x);
        return $x;
    }

    /**
     * @Route("/correct/{id}-{paragraphNumber}", name="transcript_correct", methods={"GET"})
     */
    public function correct(Transcript $transcript, $paragraphNumber=1): Response
    {
        return $this->render('transcript/correct.html.twig', [
            'transcript' => $transcript,
            'paragraphNumber' => $paragraphNumber
        ]);

    }

    /**
     * @Route("/json/{id}", name="transcript_json", methods={"GET"})
     */
    public function transcript_json(Transcript $transcript, SerializerInterface $serializer): JsonResponse
    {
        $data = $serializer->serialize($transcript, 'json', ['groups' => ['Default']]);
        // return $this->json($data);
        return new JsonResponse(json_decode($data));
    }

    /**
     * @Route("/{id}", name="transcript_show", methods={"GET"})
     */
    public function show(Transcript $transcript): Response
    {
        $a = $this->split($transcript->getAttempt());
        $b = $this->split($transcript->getText());

        $options = array(
            'ignoreWhitespace' => true,
            // 'ignoreNewLines' => true,
            //'ignoreCase' => true,
        );


        $diff = new Diff($a, $b, $options);

        $renderer = new SideBySide();
        $contextRenderer = new Context();
        dump($a, $b);

        /*
        $builder = new StrictUnifiedDiffOutputBuilder([
            'collapseRanges'      => true, // ranges of length one are rendered with the trailing `,1`
            'commonLineThreshold' => 6,    // number of same lines before ending a new hunk and creating a new one (if needed)
            'contextLines'        => 3,    // like `diff:  -u, -U NUM, --unified[=NUM]`, for patch/git apply compatibility best to keep at least @ 3
            'fromFile'            => '',
            'fromFileDate'        => null,
            'toFile'              => '',
            'toFileDate'          => null,
        ]);
        $differ = new Differ($builder);
        print '<pre>' .  $differ->diff($a, $b) . '</pre>';
        die();
        */



        return $this->render('transcript/show.html.twig', [
            'transcript' => $transcript,
            'side' => $diff->render($renderer),
            'context' => $diff->render($contextRenderer)
        ]);
    }

    /**
     * @Route("/{id}/edit", name="transcript_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Transcript $transcript): Response
    {
        $form = $this->createForm(TranscriptType::class, $transcript);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transcript_show', $transcript->getRp());
        }

        return $this->render('transcript/edit.html.twig', [
            'transcript' => $transcript,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="transcript_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Transcript $transcript): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transcript->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($transcript);
            $entityManager->flush();
        }

        return $this->redirectToRoute('transcript_index');
    }
}
