<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Mf\FeedYaNews\Writer;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception\InvalidServiceException;
use Zend\ServiceManager\Factory\InvokableFactory;

/**
 * Plugin manager implementation for feed writer extensions
 *
 * Validation checks that we have an Entry, Feed, or Extension\AbstractRenderer.
 */
class ExtensionPluginManager extends AbstractPluginManager implements ExtensionManagerInterface
{
    /**
     * Aliases for default set of extension classes
     *
     * @var array
     */
    protected $aliases = [
        'contentrendererentry'       => Extension\Content\Renderer\Entry::class,
        'contentRendererEntry'       => Extension\Content\Renderer\Entry::class,
        'ContentRendererEntry'       => Extension\Content\Renderer\Entry::class,
        'ContentRenderer\Entry'      => Extension\Content\Renderer\Entry::class,
        'Content\Renderer\Entry'     => Extension\Content\Renderer\Entry::class,
        'dublincorerendererentry'    => Extension\DublinCore\Renderer\Entry::class,
        'dublinCoreRendererEntry'    => Extension\DublinCore\Renderer\Entry::class,
        'DublinCoreRendererEntry'    => Extension\DublinCore\Renderer\Entry::class,
        'DublinCoreRenderer\Entry'   => Extension\DublinCore\Renderer\Entry::class,
        'DublinCore\Renderer\Entry'  => Extension\DublinCore\Renderer\Entry::class,
        'dublincorerendererfeed'     => Extension\DublinCore\Renderer\Feed::class,
        'dublinCoreRendererFeed'     => Extension\DublinCore\Renderer\Feed::class,
        'DublinCoreRendererFeed'     => Extension\DublinCore\Renderer\Feed::class,
        'DublinCoreRenderer\Feed'    => Extension\DublinCore\Renderer\Feed::class,
        'DublinCore\Renderer\Feed'   => Extension\DublinCore\Renderer\Feed::class,
    ];

    /**
     * Factories for default set of extension classes
     *
     * @var array
     */
    protected $factories = [
        Extension\Content\Renderer\Entry::class       => InvokableFactory::class,
        Extension\DublinCore\Renderer\Entry::class    => InvokableFactory::class,
        Extension\DublinCore\Renderer\Feed::class     => InvokableFactory::class,
        Extension\Slash\Renderer\Entry::class         => InvokableFactory::class,
        // Legacy (v2) due to alias resolution; canonical form of resolved
        // alias is used to look up the factory, while the non-normalized
        // resolved alias is used as the requested name passed to the factory.
        'zendfeedwriterextensionatomrendererfeed'           => InvokableFactory::class,
        'zendfeedwriterextensioncontentrendererentry'       => InvokableFactory::class,
        'zendfeedwriterextensiondublincorerendererentry'    => InvokableFactory::class,
        'zendfeedwriterextensiondublincorerendererfeed'     => InvokableFactory::class,

        'zendfeedwriterextensionslashrendererentry'         => InvokableFactory::class,
        'zendfeedwriterextensionthreadingrendererentry'     => InvokableFactory::class,
        'zendfeedwriterextensionwellformedwebrendererentry' => InvokableFactory::class,
    ];

    /**
     * Do not share instances (v2)
     *
     * @var bool
     */
    protected $shareByDefault = false;

    /**
     * Do not share instances (v3)
     *
     * @var bool
     */
    protected $sharedByDefault = false;

    /**
     * Validate the plugin (v3)
     *
     * Checks that the extension loaded is of a valid type.
     *
     * @param  mixed $plugin
     * @return void
     * @throws InvalidServiceException if invalid
     */
    public function validate($plugin)
    {
        if ($plugin instanceof Extension\AbstractRenderer) {
            // we're okay
            return;
        }

        if ('Feed' == substr(get_class($plugin), -4)) {
            // we're okay
            return;
        }

        if ('Entry' == substr(get_class($plugin), -5)) {
            // we're okay
            return;
        }

        throw new InvalidServiceException(sprintf(
            'Plugin of type %s is invalid; must implement %s\Extension\RendererInterface '
            . 'or the classname must end in "Feed" or "Entry"',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }

    /**
     * Validate plugin (v2)
     *
     * @param mixed $plugin
     * @return void
     * @throws Exception\InvalidArgumentException when invalid
     */
    public function validatePlugin($plugin)
    {
        try {
            $this->validate($plugin);
        } catch (InvalidServiceException $e) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Plugin of type %s is invalid; must implement %s\Extension\RendererInterface '
                . 'or the classname must end in "Feed" or "Entry"',
                (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
                __NAMESPACE__
            ));
        }
    }
}
