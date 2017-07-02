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
	//�б�
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

	//��ȡһ����¼������
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

	//����
    public function addAction(Request $request)
    {
		$title = $request->request->get('title');
		$content = $request->request->get('content');
		$postsObj = new posts();
		

		//����
		$postsObj->setTitle($title);
		$postsObj->setContent($content);
		
		//ʵ����
		$em = $this->getDoctrine()->getManager();

		$em->persist($postsObj);
		//echo var_dump($em);die;
		$em->flush();

		return new Response('success'.$postsObj->getId());
    }

	//�༭
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

	//ɾ��
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
		// ͨ��������ͨ����id����ѯһ����Ʒ
		//$product = $repository->find($productId);
		 
		// dynamic method names to find a single product based on a column value
		// ��̬�������ƣ������ֶε�ֵ���ҵ�һ����Ʒ
		//$product = $repository->findOneById($productId);
		//$product = $repository->findOneByName('Keyboard');
		 
		// dynamic method names to find a group of products based on a column value
		// ��̬�������ƣ������ֶ�ֵ���ҳ�һ���Ʒ
		//$products = $repository->findByPrice(19.99);
		 
		// find *all* products / ��� *ȫ��* ��Ʒ
		//$products = $repository->findAll();
	}

	//ʹ��DQL���ж����ѯ
	public function dalAction()
	{
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
			'SELECT p FROM AppBundle:posts p WHERE p.id = :id'
			)->setParameter(':id',2);
		$list = $query->getResult();

		//���������û�н��ʱ���׳�һ���쳣
		//$info = $query->getSingleResult();
		$info = $query->getOneOrNullResult();
		var_dump($info);die;
	}

	//�Զ����ѯ��֯��Repository����
	public function reposAction()
	{
		$qb = $this->getDoctrine()->getRepository('AppBundle:posts');
		var_dump($qb->test());die;
	}

	//��������
	public function assaddAction()
	{
		$datetime = date('Y-m-d H:i:s',time());
		//һ��
		$post = new BlogPost();
		$post->setTitle('���������');
		$post->setContent('���Ȱ�');
		$post->setCreatedAt($datetime);

		//���
		$comment = new BlogComment();
		$comment->setAuthor('����');
		$comment->setContent('�԰������Ȱ�');
		$comment->setCreatedAT($datetime);

		//����ʵ��
		$comment->setPost($post);

		$em = $this->getDoctrine()->getManager();
		$em->persist($post);
		$em->persist($comment);

		$em->flush();

		return new Response('success');
	}
}