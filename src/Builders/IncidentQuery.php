<?php

namespace CheckItOnUs\StatusPage\Builders;

use CheckItOnUs\StatusPage\Server;
use CheckItOnUs\StatusPage\Incident;
use CheckItOnUs\StatusPage\Builders\BaseQuery;

class IncidentQuery extends BaseQuery
{

    /**
     * Finds a specific Incident by the ID
     *
     * @param      integer  $id     The identifier
     *
     * @return     \CheckItOnUs\StatusPage\Incident
     */
    public function findById($id)
    {
        $pages = $this->getServer()
                    ->request()
                    ->get(Incident::getApiRootPath());

        foreach($pages as $page) {
            $incident = $page->first(function($incident) use($id) {
                return $incident->id == $id;
            });

            if($incident !== null) {
                $incident = (array)$incident;

                if(isset($incident['metadata'])) {
                    unset($incident['metadata']);
                }

                return new Incident(
                    $this->getServer(),
                    (array)$incident
                );
            }
        }

        return null;
    }

    /**
     * Finds a specific Incident based on the name
     *
     * @param      string     $name   The name
     *
     * @return     CheckItOnUs\StatusPage\Incident
     */
    public function findByName($name)
    {
        $pages = $this->getServer()
                    ->request()
                    ->get(Incident::getApiRootPath());

        foreach($pages as $page) {
            $incident = $page->first(function($incident) use($name) {
                return $incident->name == $name;
            });

            if($incident !== null) {
                return new Incident(
                    $this->getServer(),
                    (array)$incident
                );
            }
        }

        return null;
    }

    /**
     * Retrieves all of the Components on the server
     *
     * @return     \Illuminate\Support\Collection
     */
    public function all()
    {
        $pages = $this->getServer()
                    ->request()
                    ->get(Incident::getApiRootPath());

        $incidents = collect();

        foreach($pages as $page) {
            foreach($page as $incident) {
                $incidents->push(
                    new Incident(
                        $this->getServer(),
                        (array)$incident
                    )
                );
            }
        }

        return $incidents;
    }
}