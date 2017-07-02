<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TestController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction($page)
    {
		echo 'page:'.$page .'</br>';
        echo 2222;die;
        //return $this->render('default/index.html.twig', [
            //'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        //]);
    }

	public function showAction(Request $request){
		//获取get过来的参数
		$val = $request->query->get('aaa');
		//获取post过来的参数
		//$val = $request->request->get('aaa');
		var_dump($val);
		echo '<pre>';
		print_r($val);
		echo '</pre>';
		die;
		$obj = $this->get('router')->match('/getInfo/1/23');
		echo '<pre>';
		print_r($obj);
		echo '</pre>';
		echo '</br>';
		$obj2 = $this->get('router')->generate('_test_show',['sl' => 'bbb'], UrlGeneratorInterface::ABSOLUTE_URL);
		echo '<pre>';
		print_r($obj2);
		echo '</pre>';
		echo '</br>';
		echo $sl.'</br>';
		echo 1111111;die;
	}
}
