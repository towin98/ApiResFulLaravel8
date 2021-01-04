<?php

namespace App\Traits;

/**
 *
 */
trait AdminAccions
{
    public function before($user, $ability)
    {
        if ($user->esAdministrador()) {
            return true;
        }
    }

}
