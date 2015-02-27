<?php

namespace CW\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CWUserBundle extends Bundle
{
    /**
     * @return string
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
