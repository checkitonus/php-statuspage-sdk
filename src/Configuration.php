<?php

namespace CheckItOnUs\StatusPage;

use ArrayAccess;
use CheckItOnUs\StatusPage\Traits\HasMetadata;

class Configuration implements ArrayAccess
{
    use HasMetadata;

    /**
     * Initialize and hydrate the configuration object.
     *
     * @param      array  $values  The values
     */
    public function __construct($values = [])
    {
        if(!isset($values['base_url'])) {
            $values['base_url'] = 'https://api.statuspage.io/v1/pages';
        }
        
        // Ensure the data for the configuration is correct
        if(!empty($values) && is_array($values)) {
            // It is, so populate it
            $this->setMetadata($values);
        }
    }
}