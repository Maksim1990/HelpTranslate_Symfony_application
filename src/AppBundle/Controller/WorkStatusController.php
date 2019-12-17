<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class WorkStatusController extends Controller
{


    /**
     * @Route("{_locale}/accept_work_ajax" , name="accept_work_ajax")
     */
    public function acceptWorkAction(Request $request) {
        if($work_id=$request->request->get('work_id')){
            $workStatus=$this->getDoctrine()->getRepository('AppBundle:WorkStatus')->findOneBy(array('workId'=>$work_id));
            $now=new\DateTime('now');
            $teacher_description=$request->request->get('teacher_description');
            $workStatus->setWorkStatus('Accepted');
            $workStatus->setTeacherDescription($teacher_description);
            $workStatus->setUpdatedAt($now);
            $em=$this->getDoctrine()->getManager();
            $em->persist($workStatus);
            $em->flush();

            $arrData = ['output' => 'true'];
            return new JsonResponse($arrData);
        }
    }


    /**
     * @Route("{_locale}/decline_work_ajax" , name="decline_work_ajax")
     */
    public function declineWorkAction(Request $request) {
        if($work_id=$request->request->get('work_id')){
            $workStatus=$this->getDoctrine()->getRepository('AppBundle:WorkStatus')->findOneBy(array('workId'=>$work_id));
            $now=new\DateTime('now');
            $teacher_description=$request->request->get('teacher_description');
            $workStatus->setWorkStatus('Declined');
            $workStatus->setTeacherDescription($teacher_description);
            $workStatus->setUpdatedAt($now);
            $em=$this->getDoctrine()->getManager();
            $em->persist($workStatus);
            $em->flush();

            $arrData = ['output' => 'true'];
            return new JsonResponse($arrData);
        }
    }



}
