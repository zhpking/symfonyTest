<?php

namespace AppBundle\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\posts;
use AppBundle\Entity\BlogPost;
use AppBundle\Entity\BlogComment;

class PostsController extends Controller
{
	//列表
	public function indexAction()
	{
		$list = $this->getDoctrine()
			->getRepository('AppBundle:posts')
			->findAll();
		if(!$list[0]){
			throw $this->createNotFoundException('not found obj');
		}else{
			return new Response('success');
		}
	}

	//获取一条记录的详情
	public function detailAction($id)
	{
		$info = $this->getDoctrine()
			->getRepository('AppBundle:posts')
			->find($id);
		if(!$info){
			throw $this->createNotFoundException('not found obj');
		}else{
			return new Response('id:'.$info->getId().',title:'.$info->getTitle().',content:'.$info->getContent());
		}
	}

	//添加
    public function addAction(Request $request)
    {
		$title = $request->request->get('title');
		$content = $request->request->get('content');
		$postsObj = new posts();
		

		//设置
		$postsObj->setTitle($title);
		$postsObj->setContent($content);
		
		//实例化
		$em = $this->getDoctrine()->getManager();

		$em->persist($postsObj);
		//echo var_dump($em);die;
		$em->flush();

		return new Response('success'.$postsObj->getId());
    }

	//编辑
	public function editAction(Request $request,$id)
	{
		$em = $this->getDoctrine()->getManager();
		$postsObj = $em->getRepository('AppBundle:posts')->find($id);
		if(!$postsObj){
			throw $this->createNotFoundException('not found obj');
		}else{
			$title = $request->request->get('title');
			$content = $request->request->get('content');
			$postsObj->setTitle($title);
			$postsObj->setContent($content);
			$em->flush();
			return new Response('success');
		}
	}

	//删除
	public function delAction(Request $request)
	{
		$id = $request->request->get('id');
		$em = $this->getDoctrine()->getManager();
		$postsObj = $em->getRepository('AppBundle:posts')->find($id);
		if(!$postsObj){
			throw $this->createNotFoundException('not found obj');
		}else{
			$em->remove($postsObj);
			$em->flush();
			return new Response('success');
		}
	}

	public function demo(){
		//$repository = $this->getDoctrine()->getRepository('AppBundle:Product');
 
		// query for a single product by its primary key (usually "id")
		// 通过主键（通常是id）查询一件产品
		//$product = $repository->find($productId);
		 
		// dynamic method names to find a single product based on a column value
		// 动态方法名称，基于字段的值来找到一件产品
		//$product = $repository->findOneById($productId);
		//$product = $repository->findOneByName('Keyboard');
		 
		// dynamic method names to find a group of products based on a column value
		// 动态方法名称，基于字段值来找出一组产品
		//$products = $repository->findByPrice(19.99);
		 
		// find *all* products / 查出 *全部* 产品
		//$products = $repository->findAll();
	}

	//使用DQL进行对象查询
	public function dalAction()
	{
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
			'SELECT p FROM AppBundle:posts p WHERE p.id = :id'
			)->setParameter(':id',2);
		$list = $query->getResult();

		//这个方法在没有结果时会抛出一个异常
		//$info = $query->getSingleResult();
		$info = $query->getOneOrNullResult();
		var_dump($info);die;
	}

	//自定义查询组织到Repository类中
	public function reposAction()
	{
		$qb = $this->getDoctrine()->getRepository('AppBundle:posts');
		var_dump($qb->test());die;
	}

	//关联操作
	public function assaddAction()
	{
		$datetime = date('Y-m-d H:i:s',time());
		//一的
		$post = new BlogPost();
		$post->setTitle('今天的天气');
		$post->setContent('好热啊');
		$post->setCreatedAt($datetime);

		//多的
		$comment = new BlogComment();
		$comment->setAuthor('张三');
		$comment->setContent('对啊，好热啊');
		$comment->setCreatedAT($datetime);

		//关联实体
		$comment->setPost($post);

		$em = $this->getDoctrine()->getManager();
		$em->persist($post);
		$em->persist($comment);

		$em->flush();

		return new Response('success');
	}
}