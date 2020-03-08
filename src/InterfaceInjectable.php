<?php

namespace Paginator;

interface InterfaceInjectable
{
    /**
     * Set the source of data for the repository.
     *
     * @param $input
     * @return mixed
     */
    public function setInput($input);
}