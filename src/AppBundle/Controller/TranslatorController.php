<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Translator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Eko\GoogleTranslateBundle\Translate\Method\Detector;

class TranslatorController extends Controller
{
    /**
     * @Route("{_locale}/translate/{id}",name="translate")
     */
    public function translateAction($id)
    {
        //Detect any languge by phrase
      //  $detector = $this->get('eko.google_translate.detector');
        // Translates phrase to specified language
      //  $translator = $this->get('eko.google_translate.translator');
    //    $test=$detector->detect('добры дзень');
      //  $value = $translator->translate('Hi, this is my text to detect!', 'be', 'en');

        return $this->render('translate/index.html.twig',array(
        //    'value'=> $value,
//            'test'=> $test,
        ));
    }

    /**
     * @Route("{_locale}/translate_ajax" , name="translate_ajax")
     */
    public function ajaxTranslateAction(Request $request)
    {

        $input_lang=$request->request->get('input_lang');
        $output_lang=$request->request->get('output_lang');
            $translator = new Translator;
            $input_word=$request->request->get('input_word');
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $now=new\DateTime('now');
            $translator_service = $this->get('eko.google_translate.translator');

            $output_word = $translator_service->translate($input_word,  $output_lang, $input_lang);

            $translator->setInputLang($input_lang);
            $translator->setOutputLang($output_lang);
            $translator->setInputWord($input_word);
            if($output_word){
                $translator->setOutputWord($output_word);
                $translator->setUserId($user->getId());
                $translator->setCreatedAt($now);

                $em=$this->getDoctrine()->getManager();
                $em->persist($translator);
                $em->flush();

            }else{
                $output_word='Sorry, currently can not translate on this language';
            }

            $arrData = ['output' => $output_word];
            return new JsonResponse($arrData);

    }



}
