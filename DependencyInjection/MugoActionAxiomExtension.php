<?php
namespace Mugo\ActionAxiomBundle\DependencyInjection;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\Config\Resource\FileResource;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class MugoActionAxiomExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $environment = $container->getParameter( 'kernel.environment' );
        $fileLocator = new FileLocator(__DIR__ . '/../Resources/config');
        $loader = new Loader\YamlFileLoader( $container, $fileLocator );
        $standardConfigFileTypes = array(
            'app',
        );
        foreach( $standardConfigFileTypes as $type )
        {
            $found = true;
            // load env file
            try
            {
                $loader->load( $type . '_' . $environment . '.yml' );
            }
            catch( \InvalidArgumentException $e )
            {
                $found = false;
                // file missing on filesystem - it's expected
            }
            // fallback to non-env file
            if( !$found )
            {
                try
                {
                    $loader->load( $type . '.yml' );
                }
                catch( \InvalidArgumentException $e )
                {
                    // file missing on filesystem - it's expected
                }
            }
        }
    }
    /**
     * Extending the 'ezpublish' configuration section
     *
     * @param ContainerBuilder $container
     */
    public function prepend( ContainerBuilder $container )
    {
        // more specific configuration before more generic config
        $standardConfigFileTypes = array(
            'ezplatform',
        );
        foreach( $standardConfigFileTypes as $file )
        {
            $configFile = __DIR__ . '/../Resources/config/'. $file .'.yaml';
            if( file_exists( $configFile ) )
            {
                $config = Yaml::parse( file_get_contents( $configFile ) );
                if( !empty( $config ) && isset( $config[ 'ezplatform' ] ) )
                {
                    $container->prependExtensionConfig( 'ezpublish', $config[ 'ezplatform' ] );
                    $container->prependExtensionConfig( 'ezrichtext', $config[ 'ezrichtext' ] );
                    $container->addResource( new FileResource( $configFile ) );
                }
                else
                {
                    // report unexpected format
                }
            }
        }
    }
}