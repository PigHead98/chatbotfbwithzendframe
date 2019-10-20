<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Entity\Save_result;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {

        $listpoint = [
            'q1' => [
                'lat'  => 40.770623,
                'long' => -73.964367,
            ],
            'q2' => [
                'lat'  => 41.770623,
                'long' => -70.964367,
            ],
            'q3' => [
                'lat'  => 60.770623,
                'long' => -74.964367,
            ],

        ];
//        echo $listpoint['q1']['lat'];
//        foreach ($listpoint as $k => $v)
//        {
//            echo $k.' '.$v['lat'];
//        }
        //        $cacheDriver = new \Doctrine\Common\Cache\ArrayCache();
        //        //\Doctrine\Common\Util\Debug::dump($cacheDriver);
        //        $cacheDriver->save('cache_id', 'my_data');
        //
        //        if ($cacheDriver->contains('cache_id')) {
        //            echo 'cache exists';
        //        } else {
        //            echo 'cache does not exist';
        //        }
        //        $array = $cacheDriver->fetch('cache_id');
        //        var_dump($array);
//        die;
        //        $data = new Contact();
        //        $data->setName('Name');
        //        $data->setEmail('reystay');
        //        $data->setPhone('123');
        //
        //        $this->entityManager->persist($data);
        //        $this->entityManager->flush();

        $data  = $this->entityManager->getRepository(Save_result::class)->find('5');

        $result = json_decode($data->getJson(),true);



        echo 'sender: '.$result['entry'][0]['messaging'][0]['sender']['id'].'<br>';
        echo 'recipient: '.$result['entry'][0]['messaging'][0]['recipient']['id'].'<br>';
        echo 'timestamp: '.$result['entry'][0]['messaging'][0]['timestamp'].'<br>';
        echo 'postback title: '.$result['entry'][0]['messaging'][0]['postback']['title'].'<br>';
        echo 'postback payload: '.$result['entry'][0]['messaging'][0]['postback']['payload'].'<br>';
        die;
        return new ViewModel([
            'data'  => $data,
        ]);
    }

    public function index1Action()
    {


        return new ViewModel([
            //'data'  => $data,
        ]);
    }

}
