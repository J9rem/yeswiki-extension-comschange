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
use YesWiki\Comschange\Service\CommentService;

class CommentsTableAction extends YesWikiAction
{
    protected $aclService;
    protected $commentsService;
    
    public function run()
    {
        // get Services
        $this->aclService  = $this->getService(AclService::class);
        $this->commentsService  = $this->getService(CommentService::class);
        $coms = $this->commentsService->loadComments(''); # get all comments
        // filter on read acl on parent page
        $coms = array_filter($coms, function ($com) {
            return !empty($com['comment_on']) && $this->aclService->hasAccess('read', $com['comment_on']);
        });
        return $this->render('@core/comments-table.twig', [
            'comments' => $coms,
        ]) ;
    }
}
