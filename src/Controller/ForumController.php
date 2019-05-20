<?php
/**
 * Created by PhpStorm.
 * User: Michal Kolář
 * Date: 19. 5. 2019
 * Time: 19:13
 */

namespace App\Controller;

use App\Entity\Forum\Post;
use App\Entity\Forum\Thread;
use App\Entity\Forum\ThreadUserAccess;
use App\Form\Forum\PostType;
use App\Form\Forum\ThreadType;
use App\Service\Forum\AccessManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ForumController extends AbstractController
{
    const PER_PAGE = 10;
    const RESULT_KEY = 'result';

    /**
     * @Route("/")
     */
    public function homePage()
    {
        return $this->render('homepage.html.twig');
    }

    /**
     * @Route("/api/forum/list/{page}", defaults={"page"=1}), requirements={"id"="\d+"}, methods={"GET"})
     * @ParamConverter("page")
     *
     * @param int $page
     * @param EntityManagerInterface $entityManager
     *
     * @return JsonResponse
     */
    public function listThreads(int $page, EntityManagerInterface $entityManager)
    {
        $threadRepository = $entityManager->getRepository(Thread::class);
        $threads = $threadRepository->findBy([], ['id' => 'DESC']);

        $serializedThreads = [];
        /**
         * @var $threads Thread[]
         */
        foreach ($threads as $thread) {
            $serializedThreads[] = $thread->serialize();
        }
        return new JsonResponse([
            self::RESULT_KEY => $serializedThreads
        ]);
    }

    /**
     * @Route("/api/forum/{slug}/list/{page}", defaults={"page"=1}), requirements={"id"="\d+"}, methods={"GET"})
     * @ParamConverter("thread")
     * @ParamConverter("page")
     *
     * @param Thread $thread
     * @param int $page
     * @param EntityManagerInterface $entityManager
     * @param AccessManager $accessManager
     *
     * @return JsonResponse
     */
    public function listPosts(Thread $thread, int $page, EntityManagerInterface $entityManager, AccessManager $accessManager)
    {
        if (!$accessManager->canAccessThread($thread)) {
            throw new AccessDeniedHttpException(sprintf('Insufficient permissions to access thread "%s".', $thread->getTitle()));
        }
        $postRepository = $entityManager->getRepository(Thread::class);
        $offset = ($page - 1) * self::PER_PAGE;
        $posts = $postRepository->findBy(['thread' => $thread], ['created_at' => 'DESC'], self::PER_PAGE, $offset);
        $serializedPosts = [];
        /**
         * @var $posts Post[]
         */
        foreach ($posts as $post) {
            $posts[] = $post->serialize();
        }
        return new JsonResponse([
            self::RESULT_KEY => $serializedPosts
        ]);
    }

    /**
     * @Route("/api/forum/create", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface|EntityManager $entityManager
     *
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createThread(Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ThreadType::class);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            /**
             * @var $thread Thread
             */
            $thread = $form->getData();

            $entityManager->persist($thread);
            $entityManager->flush($thread);

            if ($user = $this->getUser()) {
                $threadAccess = new ThreadUserAccess();
                $threadAccess
                    ->setThread($thread)
                    ->setUser($user);
                $entityManager->persist($threadAccess);
                $entityManager->flush($threadAccess);
            }

            return new JsonResponse([
                self::RESULT_KEY => $thread->serialize()
            ]);
        }
        return new JsonResponse([], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/api/forum/{slug}/create", methods={"POST"})
     * @ParamConverter("thread")
     * @param Thread $thread
     * @param Request $request
     * @param EntityManagerInterface|EntityManager $entityManager
     * @param AccessManager $accessManager
     *
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createPost(Thread $thread, Request $request, EntityManagerInterface $entityManager, AccessManager $accessManager)
    {
        if (!$accessManager->canAccessThread($thread)) {
            throw new AccessDeniedHttpException(sprintf('Insufficient permissions to create posts in thread "%s".', $thread->getTitle()));
        }
        $form = $this->createForm(PostType::class);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            /**
             * @var $post Post
             */
            $post = $form->getData();
            $thread->addPost($post);
            $entityManager->persist($thread);
            $entityManager->persist($post);
            $entityManager->flush([$thread, $post]);
            return new JsonResponse([
                self::RESULT_KEY => $post->serialize()
            ]);
        }
        return new JsonResponse([], Response::HTTP_BAD_REQUEST);
    }

}