<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/5/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Description of ProshutCQRSExtension
 *
 * @author Proshut Web Development <info at proshut.biz>
 */
class ProshutCQRSExtension extends Extension {

    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load( array $configs, ContainerBuilder $container ) {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../config'));
        $loader->load('services.yaml');
    }
}