<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Query;
use AppBundle\Entity\Constant;
use Symfony\Component\HttpFoundation\JsonResponse;


class DefaultController extends Controller
{
    /**
     * @Route("{_locale}/assoc_fill/{id}/", name="assoc_fill")
     */
    public function createProductAction()
    {
        $category = new Category();
        $category->setName('Computer Peripherals');

        $product = new Product();
        $product->setName('Keyboard');
        $product->setDescription('Ergonomic and stylish!');
        $now=new\DateTime('now');
        $product->setCreatedAt($now);

        // relate this product to the category
        $product->setCategory($category);

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->persist($product);
        $em->flush();

        return new Response(
            'Saved new product with id: '.$product->getId()
            .' and new category with id: '.$category->getId()
        );
    }

    /**
 * @Route("{_locale}/assoc/{productId}", name="assoc_test")
 */
    public function showAction($productId)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($productId);

        $categoryName = $product->getCategory()->getName();

        var_dump($categoryName);
    }



    //Provide current notification to footer
    /**
     * @Route("{_locale}/notification_ajax", name="notification_ajax")
     */
    public function ajaxNotificationAction(Request $request)
   {
       $user = $this->get('security.token_storage')->getToken()->getUser();

       //Getting list of unread messages
       $em=$this->getDoctrine()->getManager();
       $qb = $em->createQueryBuilder();
       $q  = $qb->select(array('p'))
           ->from('AppBundle:Message', 'p')
           ->where('p.user= :id')
           ->andWhere('p.isRead= :isRead')
           ->setParameter('id', $user)
           ->setParameter('isRead', 0)
           ->getQuery();

       $messages= $q->getResult(Query::HYDRATE_ARRAY);
       $intMessage=count($messages);


       $qb = $em->createQueryBuilder();
       $q  = $qb->select(array('t'))
           ->from('AppBundle:WorkStatus', 't')
           ->where('t.userReviewerId= :id')
           ->andWhere('t.workStatus= :workStatus')
           ->setParameter('id', $user->getId())
           ->setParameter('workStatus', 'Pending')
           ->getQuery();

       $works= $q->getResult(Query::HYDRATE_ARRAY);
       $intWorks=count($works);


            $arrData = ['messages' => $intMessage,
                'pendingWorks'=>$intWorks
                ];

            return new JsonResponse($arrData);

    }



    /**
     * @Route("{_locale}/languages", name="languages")
     */
    public function languagesAction()
    {
        $userOnline = $this->get('security.token_storage')->getToken()->getUser();

//        $myDirectory = opendir($this->get('kernel')->getRootDir() ."/../images/flags");
        $myDirectory = opendir($this->get('kernel')->getRootDir() ."/../web/images/flags");
        while($entryName = readdir($myDirectory)) {
            $extension = substr($entryName, -3);
            if ($extension == 'svg') {
                $imageWithoutExtension=explode('.',$entryName);
                $arrayFlags[] = $imageWithoutExtension[0];
            }
        }
        closedir($myDirectory);


        //RedisLab block
        $redis = $this->container->get('snc_redis.default');
        $val = $redis->get('profile_image_path')?$redis->get('profile_image_path'):'false';

        $em=$this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $q  = $qb->select(array('p.languageType'))
            ->from('AppBundle:Todo', 'p')
            ->where(
                $qb->expr()->gte('p.id', '1')
            )
            ->orderBy('p.createDate', 'DESC')
            ->getQuery();

        $todo= $q->getResult(Query::HYDRATE_ARRAY);
            foreach ($todo as $lang){
                $languagesList[]=$lang['languageType'];
            }


        $em=$this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $q  = $qb->select(array('d.languageType'))
            ->from('AppBundle:TypeUser', 'd')
            ->where(
                $qb->expr()->gte('d.id', '1')
            )
            ->orderBy('d.createDate', 'DESC')
            ->getQuery();

        $typeUser= $q->getResult(Query::HYDRATE_ARRAY);
        foreach ($typeUser as $lang){
            $languagesList[]=$lang['languageType'];
        }
        $languagesList=array_unique($languagesList);

        //Get all teachers array with specific language
        $i=0;
        $teachers=array();
      foreach ($languagesList as $lang){
          $teachersType=$this->getDoctrine()->getRepository('AppBundle:TypeUser')->findBy(array('userType'=>'teacher',
              'languageType'=>$lang));

              foreach ($teachersType as $t) {
                  $teacher = $this->getDoctrine()->getRepository('AppBundle:User')->find($t->getUserId());
                  $teachers[$i]['name'] = $teacher->getUserName();
                  $teachers[$i]['id'] = $teacher->getId();
                  $teachers[$i]['lang'] = $lang;
                  $i++;
              }
      }

        //Get all students array with specific language
        $j=0;
        $students=array();
        foreach ($languagesList as $lang){
            $studentsType=$this->getDoctrine()->getRepository('AppBundle:TypeUser')->findBy(array('userType'=>'student',
                'languageType'=>$lang));
                foreach ($studentsType as $d) {
                    $student = $this->getDoctrine()->getRepository('AppBundle:User')->find($d->getUserId());
                    $students[$j]['name'] = $student->getUserName();
                    $students[$j]['id'] = $student->getId();
                    $students[$j]['lang'] = $lang;
                    $j++;
                }
        }



        //Get all MY WORKS array with specific language
        $j=0;
        $myWorks=array();
        foreach ($languagesList as $lang){
            $workType=$this->getDoctrine()->getRepository('AppBundle:Todo')->findBy(array('user_id'=>$userOnline->getId(),
                'languageType'=>$lang));
                    foreach ($workType as $d) {
                        $userTask = $this->getDoctrine()->getRepository('AppBundle:User')->find($d->getUserId());
                        $myWorks[$j]['name'] = $userTask->getUserName();
                        $myWorks[$j]['id'] = $userTask->getId();
                        $myWorks[$j]['lang'] = $lang;
                        $j++;
                    }
        }


        //Get all OTHER MY WORKS array with specific language
        $j=0;
        $otherWorks=array();
        foreach ($languagesList as $lang){
            $workType=$this->getDoctrine()->getRepository('AppBundle:Todo')->findBy(array(
                'languageType'=>$lang));
                foreach ($workType as $d) {
                    if ($userOnline->getId() != $d->getUserId()) {
                            $userTask = $this->getDoctrine()->getRepository('AppBundle:User')->find($d->getUserId());
                            $otherWorks[$j]['name'] = $userTask->getUserName();
                            $otherWorks[$j]['id'] = $userTask->getId();
                            $otherWorks[$j]['lang'] = $lang;
                            $j++;
                    }
                }
        }

//        //$list = "PHP Frameworks List";
//        print_r($languages);
//        $list = "languages";
//        if(!empty($languages)){
//            if(!$redis->lrange($list, 0, -1)){
//                    foreach( $languages as $lang) {
//                        foreach ($lang as $l) {
//                            $redis->rpush($list, $l);
//                        }
//                    }
//            }
//        }
//
//
//
//       // $redis->del($list);
//if($redis->lrange($list, 0, -1)){
//    $languagesList = $redis->lrange($list, 0, -1);
//}else{
//    $languagesList=[1,2,'44'];
//}


        return $this->render('languages/languages.html.twig',array(
            'val'=>$val,
            'languages'=>$languagesList,
            'arrayFlags'=>$arrayFlags,
            'teachers'=>$teachers,
            'students'=>$students,
            'myWorks'=>$myWorks,
            'otherWorks'=>$otherWorks,

        ));
    }



    /**
     * @Route("{_locale}/about/", name="about")
     */
    public function aboutAction()
    {
        return $this->render('about.html.twig',array(

        ));
    }

    /**
     * @Route("{_locale}/contact/", name="contact")
     */
    public function contactAction()
    {
        return $this->render('contact.html.twig',array(

        ));
    }




}
