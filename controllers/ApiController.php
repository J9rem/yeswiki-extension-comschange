<?php

namespace YesWiki\Comschange\Controller;

use Symfony\Component\Routing\Annotation\Route;
use YesWiki\Bazar\Controller\ApiController as BazarApiController;
use YesWiki\Bazar\Controller\EntryController;
use YesWiki\Core\ApiResponse;
use YesWiki\Core\Service\AclService;
use YesWiki\Core\Service\CommentService;
use YesWiki\Core\YesWikiController;

class ApiController extends YesWikiController
{
    /**
     * @Route("/api/entries/html/{selectedEntries}", methods={"GET"}, options={"acl":{"public"}},priority=2)
     */
    public function getAllEntries($selectedEntries = null)
    {
        // fast access for one entry
        if ($this->isEntryViewFastAccess($selectedEntries, $_GET)) {
            $entryId = explode(',', $selectedEntries)[0];
            if ($this->getService(AclService::class)->hasAccess('read', $entryId)) {
                $html = $this->getService(EntryController::class)->view($entryId, '', 1);
                $renderedComments = $this->getService(CommentService::class)->renderCommentsForPage($entryId);
                if (!empty($renderedComments)){
                    $renderedComments = preg_replace(
                        '/(href="[^ ]+)api\/pages\/[^\/]+\/comments"/',
                        "$1$entryId\"",
                        $renderedComments
                    );
                    $renderedComments = preg_replace(
                        '/(href="[^ ]+)api\/comments\/([^\/]+)\/delete"/',
                        "$1$2/deletepage\"",
                        $renderedComments
                    );
                    $trad = _t('COMMENTS_ADD_COMMENT');
                    $renderedComments = preg_replace(
                        '/<form id="post-comment"[\s\S]*<\/form>/',
                        <<<HTML
                        <a class="btn btn-xs btn-primary" href="{$this->wiki->href('',$entryId)}">$trad</a>
                        HTML,
                        $renderedComments
                    );
                    $match = [];
                    if (preg_match('/(<div class="clearfix"><\/div>\s*<div class="BAZ_fiche_info">)/',$html,$match)){
                        $pos = strrpos($html,$match[0]);
                        $html = substr($html,0,$pos)
                            .$renderedComments
                            .substr($html,$pos);
                    } else {
                        $match = [];
                        if (preg_match('/(<\/div>\s*)$/',$html,$match)){
                            $pos = strrpos($html,$match[0]);
                            $html = substr($html,0,$pos)
                                .$renderedComments
                                .substr($html,$pos);
                        }
                    }
                }
                return new ApiResponse(empty($html) ? null : [$entryId => ['html_output' => $html]]);
            }
            
        }
        return $this->getService(BazarApiController::class)->getAllEntries('html',$selectedEntries);
    }

    /**
     * helper to check if EntryView fast access
     * @param null|string $selectedEntries
     * @param null|array $get
     * @param bool
     */
    private function isEntryViewFastAccess($selectedEntries, $get): bool
    {
        return (!empty($selectedEntries) && is_string($selectedEntries) && count(explode(',', $selectedEntries)) == 1
            && !empty($get['fields']) && $get['fields'] == 'html_output');
    }
}
