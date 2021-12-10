<?php

namespace App\Helper;

use Illuminate\Contracts\Session\Session;

class SessionUnlock
{
    /**
     * @var Illuminate\Contracts\Session\Session
     */
    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function addUnlockFlag()
    {
        $this->session->put('isUnlocked', true);
    }

    public function isUnlocked()
    {
        return $this->session->get('isUnlocked', false);
    }
}
