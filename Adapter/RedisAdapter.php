<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/
namespace TheliaCacheRedisAdapter\Adapter;

use Symfony\Component\Cache\Adapter\RedisAdapter as RedisAdapterCore;
use Predis\Client;
use TheliaCacheRedisAdapter\TheliaCacheRedisAdapter;

class RedisAdapter extends RedisAdapterCore
{
    /**
     * RedisAdapter constructor.
     * @param string $namespace
     * @param string $defaultLifetime
     * @param int $environment
     */
    public function __construct($namespace, $defaultLifetime, $environment)
    {
        $namespace = TheliaCacheRedisAdapter::getConfigValue('namespace', $namespace);

        $parameters = json_decode(
            TheliaCacheRedisAdapter::getConfigValue('parameters', '{}'),
            true
        );

        $options = json_decode(
            TheliaCacheRedisAdapter::getConfigValue('options', '{}'),
            true
        );

        $client = new Client(
            empty($parameters) ? null : $parameters,
            empty($options) ? null : $options
        );

        parent::__construct($client, $namespace . '_' . $environment, $defaultLifetime);
    }
}
