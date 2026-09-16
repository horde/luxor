<?php

declare(strict_types=1);
/**
 * Luxor configuration class
 *
 * Provides access to the Luxor configuration settings.
 *
 * Old pattern: globals $conf; $somethingDetail = $conf['something']['detail']; *
 * New pattern: $config = $injector->get(LuxorConfig::class); $somethingDetail = $config->get('something.detail');
 *
 * Prefer DI over instantiating $config in your code.
 */

namespace Horde\Luxor;

use Horde\Core\Config\State;
use Horde\Injector\Attribute\Factory;

#[Factory(factory: LuxorConfigFactory::class, method: 'create')]
class LuxorConfig extends State {}
