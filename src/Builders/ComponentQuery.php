<?php

namespace CheckItOnUs\StatusPage\Builders;

use CheckItOnUs\StatusPage\Server;
use CheckItOnUs\StatusPage\Component;
use CheckItOnUs\StatusPage\Builders\BaseQuery;

class ComponentQuery extends BaseQuery
{
    /**
     * Finds a specific Component by the ID
     *
     * @param      integer  $id     The identifier
     *
     * @return     \CheckItOnUs\StatusPage\Component
     */
    public function findById($id)
    {
        $pages = $this->getServer()
                    ->request()
                    ->get(Component::getApiRootPath());

        foreach($pages as $page) {
            if($page === null) {
                return null;
            }

            $component = $page->first(function($component) use($id) {
                return $component->id == $id;
            });

            if($component !== null) {
                return new Component(
                    $this->getServer(),
                    (array)$component
                );
            }
        }

        return null;
    }

    /**
     * Finds a specific Component based on the name
     *
     * @param      string     $name   The name
     *
     * @return     CheckItOnUs\StatusPage\Component
     */
    public function findByName($name)
    {
        $pages = $this->getServer()
                    ->request()
                    ->get(Component::getApiRootPath());

        foreach($pages as $page) {
            if($page === null) {
                return null;
            }

            $component = $page->first(function($component) use($name) {
                return $component->name == $name;
            });

            if($component !== null) {
                return new Component(
                    $this->getServer(),
                    (array)$component
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
                    ->get(Component::getApiRootPath());

        $components = collect();

        foreach($pages as $page) {
            foreach($page as $component) {
                $components->push(
                    new Component(
                        $this->getServer(),
                        (array)$component
                    )
                );
            }
        }

        return $components;
    }
}
