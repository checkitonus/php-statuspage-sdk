<?php

namespace CheckItOnUs\StatusPage;

use CheckItOnUs\StatusPage\Server;
use CheckItOnUs\StatusPage\ComponentGroup;
use CheckItOnUs\StatusPage\Decorators\Tags;
use CheckItOnUs\StatusPage\BaseApiComponent;
use CheckItOnUs\StatusPage\Traits\HasApiRoutes;
use CheckItOnUs\StatusPage\Builders\ComponentQuery;

class Component extends BaseApiComponent
{
    const OPERATIONAL = 'operational';
    const DEGRADED_PERFORMANCE = 'degraded_performance';
    const PARTIAL_OUTAGE = 'partial_outage';
    const MAJOR_OUTAGE = 'major_outage';
    const UNDER_MAINTENANCE = 'under_maintenance';

    /**
     * Dictates the server that the Component relates to.
     *
     * @param      \CheckItOnUs\StatusPage\Server  $server  The server
     */
    public static function on(Server $server)
    {
        return (new ComponentQuery())
            ->onServer($server);
    }

    public static function getApiRootPath()
    {
        return 'components';
    }

    /**
     * Returns the wrapper object for the post request.
     * 
     * @return string
     */
    public function getWrapper()
    {
        return 'component';
    }

    public function getIgnored()
    {
        return [
            'page_id',
            'id',
            'position',
            'updated_at',
            'created_at',
        ];
    }

    /**
     * Retrieves the current status code of the component
     *
     * @return     int  The status.
     */
    public function getStatus()
    {
        return isset($this->_metadata['status']) ? $this->_metadata['status'] : self::OPERATIONAL;
    }

    /**
     * Sets the tags.
     *
     * @param      object|array  $value  The value
     *
     * @return     CheckItOnUs\StatusPage\Component
     */
    public function setTags($value)
    {
        $this->_metadata['tags'] = new Tags(array_filter((array)$value));
        return $this;
    }

    /**
     * Gets the tags.
     *
     * @return     Illuminate\Support\Collection  The tags.
     */
    public function getTags()
    {
        return empty($this->_metadata['tags']) ? new Tags() : $this->_metadata['tags'];
    }

    /**
     * Adds a tag to the list.
     *
     * @param      string  $value  The value
     *
     * @return     CheckItOnUs\StatusPage\Component
     */
    public function addTag($value)
    {
        $this['tags']->push($value);
        return $this;
    }

    /**
     * Converts the status name field into the status code which is required.
     *
     * @param      string  $value  The value
     *
     * @return     CheckItOnUs\StatusPage\Component
     */
    public function setStatusName($value)
    {
        // Try to translate the status
        if(isset($value)) {
            // It existed, so translate into something we understand
            $status = strtoupper($value);
            $this['status'] = constant(self::class . '::' . str_replace(' ', '_', $status));
        }

        return $this;
    }
}