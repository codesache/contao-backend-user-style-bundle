<?php

namespace Codesache\BackendUserStyleBundle;

use Codesache\BackendUserStyleBundle\EventListener\BackendStyleListener;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class CodesacheBackendUserStyleBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
                ->arrayNode('css')
                    ->defaultValue([
                        'bundles/codesachebackenduserstyle/backend-cs.css',
                        'bundles/codesachebackenduserstyle/backend-username.css',
                    ])
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('js')
                    ->defaultValue([
                        'bundles/codesachebackenduserstyle/backend-cs.js',
                    ])
                    ->scalarPrototype()->end()
                ->end()
            ->end();
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import(__DIR__ . '/../config/services.yaml');

        $builder->getDefinition(BackendStyleListener::class)
            ->setArgument('$cssFiles', $config['css'])
            ->setArgument('$jsFiles', $config['js']);
    }
}
