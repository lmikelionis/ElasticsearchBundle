<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle;

use ONGR\ElasticsearchBundle\DependencyInjection\Compiler\MappingPass;
use Symfony\Component\ClassLoader\MapClassLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * ONGR Elasticsearch bundle system file required by kernel.
 */
class ONGRElasticsearchBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MappingPass());
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if ($this->container->hasParameter('es.proxy_paths')) {
            $loader = new MapClassLoader($this->container->getParameter('es.proxy_paths'));
            $loader->register();
        }
    }
}
