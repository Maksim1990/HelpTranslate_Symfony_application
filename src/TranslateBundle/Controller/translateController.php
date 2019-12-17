<?php


namespace TranslateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
class translateController extends Controller
{

    /**
     * @Route("{_locale}/translation")
     */
    public function showAction(){

        return $this->render('TranslateBundle:Default:translate.html.twig');
    }

}