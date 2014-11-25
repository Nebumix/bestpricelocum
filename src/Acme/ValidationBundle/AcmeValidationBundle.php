<?php

namespace Acme\ValidationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AcmeValidationBundle extends Bundle
{
    public function getParent()
    {
        return 'NebumixrtValidationBundle';
    }
}
