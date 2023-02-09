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

class MyCommentsAction extends YesWikiAction
{

    public function run()
    {
        return $this->callAction('usercomments', $this->arguments);
    }
}
