<?php

namespace Codesache\BackendUserStyleBundle;

use Codesache\BackendUserStyleBundle\EventListener\BackendStyleListener;
use Codesache\BackendUserStyleBundle\EventListener\DataContainer\ContentTypeClassListener;
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
                ->variableNode('content_types')
                    ->info("Typ-Klasse be-type-<typ> am .cte_type: 'wrappers' | 'all' | Liste von Elementtypen")
                    ->defaultValue('wrappers')
                ->end()
                ->booleanNode('strip_wrapper_group')
                    ->info('Kategorie-Präfix bei Wrappern entfernen: „Grid (Reihe Start)“ → „Reihe Start“')
                    ->defaultTrue()
                ->end()
            ->end();
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import(__DIR__ . '/../config/services.yaml');

        $builder->getDefinition(BackendStyleListener::class)
            ->setArgument('$cssFiles', $config['css'])
            ->setArgument('$jsFiles', $config['js']);

        $builder->getDefinition(ContentTypeClassListener::class)
            ->setArgument('$contentTypes', $config['content_types'])
            ->setArgument('$stripWrapperGroup', $config['strip_wrapper_group']);
    }
}
