<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\Query;

class MessageController extends Controller
{

    /**
     * @Route("{_locale}/messages/{id}",name="messages_list")
     */
    public function messagesAction($id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $messageList=$user->getMessages();
        $messageList=$this->getDoctrine()->getRepository('AppBundle:Message')->findAll();

        $em=$this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Message')
            ->createQueryBuilder('c');

        $messageWithoutReceiver = $queryBuilder->select('c')
            ->where('c.userSender = :user')
            ->setParameter(':user', $user->getId())
            ->getQuery()
            ->getResult();




        $qb = $em->createQueryBuilder();
        $q  = $qb->select(array('p'))
            ->from('AppBundle:Message', 'p')
            ->where('p.user= :id')
            ->andWhere('p.isRead= :isRead')
            ->setParameter('id', $user)
            ->setParameter('isRead', 0)
            ->getQuery();
        $messages= $q->getResult(Query::HYDRATE_ARRAY);
        $arrMess=array();
        foreach ($messages as $mes){
            $j=1;
            if(in_array($mes['userSenderId'],array_keys($arrMess))){
                $arrMess[$mes['userSenderId']]=$arrMess[$mes['userSenderId']]+1;
            }else{
                $arrMess[$mes['userSenderId']]=$j;
            }

        }


//        /**
//         * @var $paginator Knp\Component\Pager\Paginator
//         */
//        $paginator=$this->get('knp_paginator');
//        $resultWorks=$paginator->paginate(
//            $works,
//            $request->query->getInt('page',1),
//            $request->query->getInt('limit',10)
//        );




        return $this->render('messages/index.html.twig',array(

            'user'=>$user,
            'messageList'=>$messageList,
            'arrMess'=>$arrMess,
            'messages'=>$messageList,
            'messageWithoutReceiver'=>$messageWithoutReceiver,

        ));
    }

    /**
     * @Route("{_locale}/message_box/{id}" , name="message_box")
     */
    public function allMessagesAction($id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $messagesAll=$user->getMessages();
        return $this->render('messages/message_box.html.twig',array(
            'messages'=>$messagesAll,
            'user'=>$user,
        ));
    }

    /**
     * @Route("{_locale}/find_user/ajax" , name="find_user_ajax")
     */
    public function ajaxAction(Request $request) {
        $search=$request->request->get('search');
        $userOnline = $this->get('security.token_storage')->getToken()->getUser();
        if(isset($search)){

            $em=$this->getDoctrine()->getManager();
            $result = $em->createQueryBuilder();
            if(!empty($search)){
                $users = $result->select('p')
                    ->from('AppBundle:User', 'p')
                    ->where('p.username LIKE :name')
                    ->andWhere('p.id !=:userId')
                    ->setParameter('name', '%'.$search.'%')
                    ->setParameter('userId', $userOnline->getId())
                    ->orderBy('p.id','ASC')
                    ->getQuery()
                    ->getResult();
            }else{
                $users = $result->select('p')
                    ->from('AppBundle:User', 'p')
                    ->where('p.id !=:userId')
                    ->setParameter('userId', $userOnline->getId())
                    ->orderBy('p.id', 'DESC')
                    ->setMaxResults(10)
                    ->getQuery()
                    ->getResult();
            }

            if(isset($users) && !empty($users)){
            $i=0;
            foreach ($users as $user){
                $image = $user->getImage();
                    $userResult[$i]['username'] = $user->getUsername();
                    $userResult[$i]['id'] = $user->getId();
                if(isset($image) &&  !empty($image-> getImageName())){
                    $imageName='/images/uploads/'.$image-> getImageName();
                }else{
                    $imageName='/images/layout/profile.png';
                }
                    $userResult[$i]['image_path'] = $imageName;
                    $i++;
                }
            }else{
                $userResult=false;
            }
        }else{
            $userResult=false;
        }

            $arrData = ['output' => $userResult];
            return new JsonResponse($arrData);
    }



    /**
     * @Route("{_locale}/send_new_messages_ajax" , name="send_new_messages_ajax")
     */
    public function sendMessageAjaxAction(Request $request) {
        if($messageNew=$request->request->get('message')){
            $message = new Message;
            $user_receiver_id=$request->request->get('user_receiver_id');
            $userReceiver=$this->getDoctrine()->getRepository('AppBundle:User')->find($user_receiver_id);
            $now=new\DateTime('now');
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $message->setCreatedAt($now);
            $message->setIsRead('0');
            $message->setUser($userReceiver);
            $message->setMessage($messageNew);

            $message->setUserSender($user);
            $em=$this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();


            if($user->getImage())
            {
                $imagePath='uploads/'.$user->getImage()->getImageName();
            }else{
                $imagePath='layout/profile.png';
            }


            $arrData = [
                'message' => $messageNew,
                'user_name' => $user->getUsername(),
                'user_image' => '/images/'.$imagePath,
                ];
            return new JsonResponse($arrData);
        }
    }

    /**
     * @Route("{_locale}/mark_as_read_ajax" , name="mark_as_read_ajax")
     */
    public function markAsReadAjaxAction(Request $request) {
        if($id_user_message=$request->request->get('id_user_message')){
            $userSender=$this->getDoctrine()->getRepository('AppBundle:User')->find($id_user_message);
            $userOnline = $this->get('security.token_storage')->getToken()->getUser();
            $messages=$this->getDoctrine()->getRepository('AppBundle:Message')->findBy(array('user'=>$userOnline,'userSender'=>$userSender));
            $now = new\DateTime('now');
            foreach ($messages as $message) {
                $message->setUpdatedAt($now);
                $message->setIsRead('1');
                $em = $this->getDoctrine()->getManager();
                $em->persist($message);
                $em->flush();
            }
            $arrData = [
                'output' => 'Success'
            ];
            return new JsonResponse($arrData);
        }
    }



}
