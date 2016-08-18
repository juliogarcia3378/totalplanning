<?php

namespace Core\MySecurityBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MySecurityBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
