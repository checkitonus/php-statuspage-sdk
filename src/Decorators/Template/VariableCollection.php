<?php

namespace CheckItOnUs\StatusPage\Decorators\Template;

use ArrayAccess;
use CheckItOnUs\StatusPage\Traits\HasMetadata;

class VariableCollection implements ArrayAccess
{
    use HasMetadata;

    /**
     * Retrieves the complete list of variables
     *
     * @return     array
     */
    public function all()
    {
        return $this->getMetadata();
    }
}