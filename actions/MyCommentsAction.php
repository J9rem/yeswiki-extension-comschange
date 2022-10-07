<?php

/*
 * This file is part of the YesWiki Extension comschange.
 *
 * Authors : see README.md file that was distributed with this source code.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace YesWiki\Comschange;

use YesWiki\Core\YesWikiAction;
use YesWiki\Core\Service\AclService;
use YesWiki\Core\Service\UserManager;
use YesWiki\Comschange\Service\CommentService;

class MyCommentsAction extends YesWikiAction
{
    protected $aclService;
    protected $commentsService;
    protected $userManager;

    public function run()
    {
        // get Services
        $this->userManager  = $this->getService(UserManager::class);

        $user = $this->userManager->getLoggedUser();
        if (empty($user)) {
            return $this->render('@templates/alert-message.twig', [
                'message' => _t('COMMENT_RESERVED_TO_CONNECTED'),
                'type' => 'info'
            ]) ;
        }

        $this->aclService  = $this->getService(AclService::class);
        $this->commentsService  = $this->getService(CommentService::class);
        $coms = $this->commentsService->loadComments('', $user['name']); # get all comments, only for current user
        // filter on read acl on parent page
        $coms = array_filter($coms, function ($com) {
            return !empty($com['comment_on']) && $this->aclService->hasAccess('read', $com['comment_on']);
        });
        return $this->render('@core/comment-table.twig', [
            'comments' => $coms,
        ]) ;
    }
}
