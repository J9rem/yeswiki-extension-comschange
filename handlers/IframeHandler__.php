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

use YesWiki\Core\Service\CommentService;
use YesWiki\Core\YesWikiHandler;

class IframeHandler__ extends YesWikiHandler
{
    public function run()
    {
        $output = '';
        if ($this->wiki->page && $this->wiki->HasAccess("read")) {
            $match = [];
            $anchor = "</div><!-- end .page-widget -->\n";
            $anchorQ = preg_quote($anchor,'/');
            $renderedComments = $this->getService(CommentService::class)->renderCommentsForPage($this->wiki->getPageTag());
            if (!empty($renderedComments) && preg_match("/($anchorQ)/",$this->output,$match)){
                $this->output = str_replace(
                    $anchor,
                    "$anchor$renderedComments\n",
                    $this->output
                );
            }
        }
        return '';
    }
}
