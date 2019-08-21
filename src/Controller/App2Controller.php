<?php

namespace App\Controller;

use Adaptive\Diff\Diff;
use Adaptive\Diff\Renderer\Html\SideBySide;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class App2Controller extends AbstractController
{
    /**
     * @Route("/app2", name="app2")
     */
    public function index()
    {
        $options = array(
            //'ignoreWhitespace' => true,
            //'ignoreCase' => true,
        );
        $some_file_path = $kernel->getProjectDir() . '/src/Controller/AppController.php';
        $some_other_file_path = $kernel->getProjectDir() . '/src/Controller/App2Controller.php';
        $a = explode("\n", file_get_contents($some_file_path));
        $b = explode("\n", file_get_contents($some_other_file_path));

        $diff = new Diff($a, $b, $options);
        $renderer = new SideBySide();
        echo $diff->Render($renderer);

        die();
        return $this->render('app2/indexXX.html.twig  ', [
            'controller_name' => 'App2Controller',
        ]);
    }
}
