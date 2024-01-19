<?php

namespace Composer\Installers;

class PantheonInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array(
        'script' => 'web/private/extensions/inc/assets/quicksilver/{$name}',
        'module' => 'web/private/extensions/inc/assets/quicksilver/{$name}',
    );
}
