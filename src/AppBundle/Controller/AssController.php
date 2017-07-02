<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Category;
use AppBundle\Entity\Good;

class AssController extends Controller
{
    public function indexAction()
    {
		$id = 1;
		$good = $this->getDoctrine()->getRepository('AppBundle:Good')->find(1);
		echo get_class($good).'</br>';
		//$categoryName = $good->getCategory()->getName();
		var_dump(get_class($good->getCategory()));die;
		foreach($good as $key => $val){
			echo $val->getId().',';
		}
		return new Response('success');
    }

	public function addAction(Request $request)
    {	
		//分类
		$category = new Category();
		$category->setName('test1');

		//商品
		$good = new Good();
		$good->setName('test1_good1');

		//关联实体
		$good->setCategory($category);

		$em = $this->getDoctrine()->getManager();
		$em->persist($good);
		$em->persist($category);

		$em->flush();

		return new Response('cate_id:'.$category->getId().',good_id:'.$good->getId());
    }

	public function editAction()
    {
		  
    }

	public function delAction()
    {
		  
    }

	public function joinAction()
	{
		$obj = $this->getDoctrine()->getRepository('AppBundle:Good');
		$a = $obj->getOne();
		echo $a->getName();
		return new Response('');
	}
}
