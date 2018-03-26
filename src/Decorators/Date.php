<?php

namespace CheckItOnUs\StatusPage\Decorators;

use Carbon\Carbon;
use CheckItOnUs\StatusPage\ApiRequest;

class Date extends Carbon implements ApiRequest
{
    /**
     * Converts the object to a format which can be used when making an API 
     * request.
     * 
     * @return mixed
     */
    public function toApi()
    {
        return $this->format('d/m/Y H:i');
    }
}