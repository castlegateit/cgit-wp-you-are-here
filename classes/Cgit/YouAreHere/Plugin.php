<?php

namespace Cgit\YouAreHere;

class Plugin
{
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        if (!defined('CGIT_YOU_ARE_HERE')) {
            return;
        }

        new Indicator;
    }
}
