<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */

namespace app;

use CodeIgniter\Session\Session;

class Common
{
    /**
     * @const ENVIRONMENT string
     */
    public const ENVIRONMENT = 'Development';

    /**
     * @const AGENT int
     */
    public const AGENT = 0;

    /**
     * @const ADMINISTRATOR int
     */
    public const ADMINISTRATOR = 1;

    /**
     * @const LEVELS array
     */
    public const LEVELS = [self::AGENT => 'Agent', self::ADMINISTRATOR => 'Administrateur'];
}
