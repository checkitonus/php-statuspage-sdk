<?php

namespace CheckItOnUs\StatusPage;

use CheckItOnUs\StatusPage\Server;
use CheckItOnUs\StatusPage\BaseApiComponent;
use CheckItOnUs\StatusPage\Decorators\Template;
use CheckItOnUs\StatusPage\Builders\IncidentQuery;

class Incident extends BaseApiComponent
{

    const SCHEDULED = 'scheduled';
    const INVESTIGATING = 'investigating';
    const IDENTIFIED = 'identified';
    const MONITORING = 'monitoring';
    const RESOLVED = 'resolved';

    /**
     * Dictates the server that the Incident relates to.
     *
     * @param      \CheckItOnUs\StatusPage\Server  $server  The server
     */
    public static function on(Server $server)
    {
        return (new IncidentQuery())
            ->onServer($server);
    }

    /**
     * Hydrates a new instance of an Incident
     *
     * @param      array  $metadata  The metadata
     */
    public function __construct(Server $server, array $metadata = [])
    {
        $this->setStatus(self::INVESTIGATING)
            ->setNotify(true)
            ->setVisible(true)
            ->setName('Incident')
            ->setMessage('No message');

        parent::__construct($server, $metadata);
    }

    /**
     * Gets the base path for the API
     *
     * @return     string  The api root path.
     */
    public static function getApiRootPath()
    {
        return 'incidents';
    }

    /**
     * Gets the elements stored in the metadata which are able to be sent to the API
     *
     * @return     array  The metadata
     */
    public function getArrayable()
    {
        return [
            'name',
            'status',
            'wants_twitter_update',
            'body',
            'component_ids',
            'components',
            'deliver_notifications',
        ];
    }

    /**
     * Returns the wrapper object for the post request.
     * 
     * @return string
     */
    public function getWrapper()
    {
        return 'incident';
    }

    public function setComponentIds($componentIds)
    {
        if(!is_array($componentIds)) {
            $componentIds = [
                $componentIds
            ];
        }

        $this->_metadata['component_ids'] = [
            'component_ids' => $componentIds
        ];

        return $this;
    }

    public function setComponents($components, $value = null)
    {
        if(!is_array($components)) {
            $components = [
                $components => $value,
            ];
        }

        $this->_metadata['components'] = [
            'components' => $components
        ];

        return $this;
    }
}