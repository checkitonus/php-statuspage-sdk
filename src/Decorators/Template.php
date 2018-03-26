<?php

namespace CheckItOnUs\StatusPage\Decorators;

use ArrayAccess;
use CheckItOnUs\StatusPage\ApiRequest;
use CheckItOnUs\StatusPage\Helpers\Slug;
use CheckItOnUs\StatusPage\Traits\HasMetadata;
use CheckItOnUs\StatusPage\Decorators\Template\VariableCollection;

class Template implements ArrayAccess, ApiRequest
{
    use HasMetadata;

    /**
     * Converts the object to a format which can be used when making an API 
     * request.
     * 
     * @return mixed
     */
    public function toApi()
    {
        return [
            'template' => Slug::generate($this['name']),
            'vars' => $this['variables']->all(),
        ];
    }

    /**
     * Retrieves the "vars" attribute
     *
     * @return     \CheckItOnUs\StatusPage\Decorators\Template\VariableCollection  The variables.
     */
    public function getVars()
    {
        return $this['variables'];
    }

    /**
     * Retrieves an array of variables to be sent to the API
     *
     * @return     array  The variables.
     */
    public function getVariables()
    {
        if(!isset($this->_metadata['variables'])) {
            $this['variables'] = [];
        }

        return $this->_metadata['variables'];
    }

    /**
     * Sets the list of template variables
     *
     * @param      array   $value  The value
     *
     * @return     \CheckItOnUs\StatusPage\Decorators\Template
     */
    public function setVariables(array $value)
    {
        $this->_metadata['variables'] = new VariableCollection($value);
        return $this;
    }

    /**
     * Adds a specific variable to the template.
     *
     * @param      string  $key    The key
     * @param      mixed  $value  The value
     *
     * @return     \CheckItOnUs\StatusPage\Decorators\Template
     */
    public function addVariable($key, $value)
    {
        $this['variables'][$key] = $value;
        return $this;
    }
}