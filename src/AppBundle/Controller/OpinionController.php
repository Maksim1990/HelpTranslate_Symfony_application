<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Opinion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class OpinionController extends Controller
{

    /**
     * @Route("{_locale}/opinions/", name="opinions")
     */
    public function opinionsAction()
    {
        //$opinions=$this->getDoctrine()->getRepository('AppBundle:Opinion')->findAll()
        $em=$this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $q  = $qb->select(array('p'))
            ->from('AppBundle:Opinion', 'p')
            ->where(
                $qb->expr()->gte('p.id', '1')
            )
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery();

        $opinions= $q->getResult();
        return $this->render('opinion/index.html.twig',array(
            'opinions'=>$opinions
        ));
    }


    /**
     * @Route("{_locale}/opinion/create", name="create_opinion")
     */
    public function createAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $opinion = new Opinion;
        $form=$this->createFormBuilder($opinion)
            ->add('opinion_text',CKEditorType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px;')))
            ->add('submit',SubmitType::class,array('label'=>'Send opinion','attr'=>array('class'=>'btn btn-primary','style'=>'margin-bottom:15px;')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $opinion_text=$form['opinion_text']->getData();

            $now=new\DateTime('now');

            $opinion->setOpinionText($opinion_text);
            $opinion->setUser($user);
            $opinion->setCreatedAt($now);
            $opinion->setUpdatedAt($now);

            $em=$this->getDoctrine()->getManager();
            $em->persist($opinion);
            $em->flush();
            $this->addFlash('notice','New opinion was successfully added!');
            return $this->redirectToRoute('opinions');
        }
        return $this->render('opinion/create.html.twig',array('form'=>$form->createView()));
    }


    /**
     * @Route("{_locale}/opinion/edit/{id}", name="edit_opinion")
     */
    public function editAction($id, Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $opinion=$this->getDoctrine()->getRepository('AppBundle:Opinion')->find($id);
        $opinion->setOpinionText($opinion->getOpinionText());
        $form=$this->createFormBuilder($opinion)
            ->add('opinion_text',CKEditorType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px;')))
            ->add('submit',SubmitType::class,array('label'=>'Edit opinion','attr'=>array('class'=>'btn btn-primary','style'=>'margin-bottom:15px;')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $opinion_text=$form['opinion_text']->getData();

            $now=new\DateTime('now');

            $opinion->setOpinionText($opinion_text);
            $opinion->setUser($user);
            $opinion->setCreatedAt($now);
            $opinion->setUpdatedAt($now);

            $em=$this->getDoctrine()->getManager();
            $em->persist($opinion);
            $em->flush();
            $this->addFlash('notice','Opinion was successfully edited!');
            return $this->redirectToRoute('opinions');
        }
        return $this->render('opinion/edit.html.twig',array('form'=>$form->createView()));
    }


}
