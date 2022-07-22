<?php
/*
 * This file is part of the YesWiki Extension comschange.
 *
 * Authors : see README.md file that was distributed with this source code.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace YesWiki\Comschange\Controller;

use Symfony\Component\Routing\Annotation\Route;
use YesWiki\Core\ApiResponse;
use YesWiki\Core\Service\CommentService;
use YesWiki\Core\YesWikiController;

class ApiController extends YesWikiController
{

    /**
     * @Route("/api/comments/{tag}",methods={"DELETE"}, options={"acl":{"public","+"}},priority=2)
     */
    public function deleteComment($tag)
    {
        if ($this->wiki->UserIsOwner($tag) || $this->wiki->UserIsAdmin()) {
            $commentService = $this->getService(CommentService::class);
            $errors = $commentService->delete($tag);
            return new ApiResponse(['success' => _t('COMMENT_REMOVED')]+$errors, 200);
        } else {
            return new ApiResponse(['error' => _t('NOT_AUTORIZED_TO_REMOVE_COMMENT')], 403);
        }
    }
    /**
     * @Route("/api/comments/{tag}/delete",methods={"GET"}, options={"acl":{"public","+"}},priority=2)
     */
    public function deleteCommentByGetMethod($tag)
    {
        return $this->deleteComment($tag);
    }
}
