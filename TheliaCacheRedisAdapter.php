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

namespace TheliaCacheRedisAdapter;

use Propel\Runtime\Connection\ConnectionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Module\BaseModule;

class TheliaCacheRedisAdapter extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'theliacacheredisadapter';

    /**
     * @inheritdoc
     */
    public function postActivation(ConnectionInterface $con = null): void
    {
        if (null === TheliaCacheRedisAdapter::getConfigValue('namespace')) {
            $namespace = $this->generateNameSpace();

            if (!empty($namespace)) {
                TheliaCacheRedisAdapter::setConfigValue('namespace', $namespace);
            }
        }
    }

    public function generateNameSpace()
    {
        /** @var Request $request */
        $request = $this->container->get('request_stack')->getCurrentRequest();

        $host = $request->getHost();

        $host = strtolower($host);

        $host = str_replace('.', '_', $host);
        $host = str_replace('www_', '', $host);

        return $host;
    }
}
