<?php

/*
 * This file is part of the YesWiki Extension comschange.
 *
 * Authors : see README.md file that was distributed with this source code.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace YesWiki\Comschange\Service;

use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyEventDispatcher;
use Throwable;
use YesWiki\Comschange\Entity\Event;
use YesWiki\Wiki;

class EventDispatcher extends SymfonyEventDispatcher
{
    protected $wiki;

    public function __construct(
        Wiki $wiki
    ) {
        parent::__construct();
        $this->wiki = $wiki;
    }


    /**
     * @param string $eventName
     * @param array $data
     * @param array $errors
     */
    public function yesWikiDispatch(string $eventName, array $data = []): array
    {
        try {
            $this->dispatch(new Event($data), $eventName);
            return [];
        } catch (Throwable $th) {
            $errors = ($this->wiki->userIsAdmin()) ? ['exception' => [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString()
            ]] : [];
            return $errors;
        }
    }
}
