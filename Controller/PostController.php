<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\BlogBundle\Controller;

use Mindy\Bundle\BlogBundle\Model\Post;
use Mindy\Bundle\CommentBundle\EventListener\CommentEvent;
use Mindy\Bundle\CommentBundle\Form\CommentForm;
use Mindy\Bundle\CommentBundle\Model\Comment;
use Mindy\Bundle\MindyBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    public function listAction()
    {
        $qs = Post::objects()->published();

        $pager = $this->createPagination($qs);

        return $this->render('blog/post/list.html', [
            'posts' => $pager->paginate(),
            'pager' => $pager->createView(),
        ]);
    }

    public function viewAction(Request $request, $slug)
    {
        /** @var Post $post */
        $post = Post::objects()->get(['is_published' => true, 'slug' => $slug]);
        if (null === $post) {
            throw new NotFoundHttpException();
        }

        $lastPosts = Post::objects()
            ->published()
            ->limit(5)
            ->order(['-id'])
            ->exclude(['id' => $post->id])
            ->all();

        $comments = $post->getComments();

        $comment = new Comment([
            'object_type' => $post->getObjectType(),
            'object_id' => $post->getObjectId(),
            'user' => $this->getUser(),
        ]);
        $commentForm = $this->createForm(CommentForm::class, $comment, [
            'method' => 'POST',
            'action' => $this->generateUrl('blog_post_view', ['slug' => $post->slug]),
        ]);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted()) {
            if ($commentForm->isValid()) {
                $comment = $commentForm->getData();
                if (false === $comment->save()) {
                    throw new \RuntimeException('Fail to save comment');
                }

                $this->get('event_dispatcher')->dispatch(
                    CommentEvent::EVENT,
                    new CommentEvent($post, $comment)
                );

                $this->addFlash('success', 'Комментарий добавлен и будет опубликован после проверки модератором.');

                return $this->redirect($request->getRequestUri());
            }
            $this->addFlash('error', 'Пожалуйста исправьте ошибки в форме.');
        }

        return $this->render('blog/post/view.html', [
            'comments' => $comments,
            'post' => $post,
            'comment_form' => $commentForm->createView(),
            'last_posts' => $lastPosts,
        ]);
    }
}
