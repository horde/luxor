<?php

declare(strict_types=1);
/**
 * Luxor configuration class factory
 *
 * Creates instances of the LuxorConfig class.
 *
 * Old pattern: globals $conf; $somethingDetail = $conf['something']['detail']; *
 * New pattern: $config = $injector->get(LuxorConfig::class); $somethingDetail = $config->get('something.detail');
 *
 * Prefer DI over instantiating $config in your code.
 */

namespace Horde\Luxor;

use Horde\Core\Config\ConfigLoader;
use Horde\Injector\Injector;

class LuxorConfigFactory
{
    public function __construct(private Injector $injector) {}

    public function create(): LuxorConfig
    {
        $state = $this->injector->get(ConfigLoader::class)->load('luxor');
        return new LuxorConfig($state->toArray());
    }
}
