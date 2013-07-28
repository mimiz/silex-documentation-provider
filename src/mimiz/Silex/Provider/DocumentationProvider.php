<?php
/**
 * Fichier DocumentationProvider.php.
 *
 * @license Copyright Sqli
 * @author  rgoyard
 * @since   28/07/13 - 01:20
 */

namespace Mimiz\Silex\Provider;

require_once __DIR__.'/DocumentationProviderException.php';

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * Class DocumentationProvider
 *
 * Provider for creating your project documentation
 *
 * @package Mimiz\Silex\Provider
 */
class DocumentationProvider implements ServiceProviderInterface
{

    /**
     * @var Application
     */
    private $app;

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        $this->app = $app;
        // DOCUMENTATION URL
        // DOCUMENTATION PATH
        // SYNTAX ADAPTER
        // EXTENSION
        // THEME
        $self = $this;
        $app['DocumentationRenderer'] = $app->share(function(Application $app) use ($self) {
            return $self->getRenderer();
        });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
        $this->app = $app;
        $app->get(
            $app["documentation.url"] . '/', function () use ($app) {
                $subRequest = Request::create($app["documentation.url"], 'GET');
                return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
            }
        );

        $app->get(
            $app["documentation.url"], function () use ($app) {
                $home = $app["documentation.dir"] . '/' . $app["documentation.home"] . '.'
                    . $app["documentation.extension"];
                if (is_file($home)) {
                    if (is_readable($home)) {
                        $content = file_get_contents($home);
                        return $app["DocumentationRenderer"]->render($content);
                    } else {
                        $app->abort("403", "Forbidden");
                    }
                } else {
                    $app->abort("404", "Documentation Page not Found ");
                }
            }
        );

        $app->get(
            $app["documentation.url"] . "/{pagename}", function (Request $request) use ($app) {
                $page
                    =
                    $app["documentation.dir"] . '/' . $request->get('pagename') . '.' . $app["documentation.extension"];
                if (is_file($page)) {
                    if (is_readable($page)) {
                        $content = file_get_contents($page);
                        return $app["DocumentationRenderer"]->render($content);
                    } else {
                        $app->abort("403", "Forbidden");

                    }
                } else {
                    $app->abort("404", "Documentation Page not Found ");
                }


            }
        )->assert('pagename', '[a-zA-Z0-9-/]*')->value("pagename", "index");
    }

    /**
     * @param $content
     *
     * @return mixed
     */
    public function getRenderer()
    {
        // Need to load adapter
        $syntax = "plain";
        if ($this->app["documentation.syntax"] !== "") {
            $syntax = $this->app["documentation.syntax"];
        }

        $clName = __NAMESPACE__ . '\\Renderer\\' . ucfirst($syntax);
        require_once __DIR__.'/Renderer/'.ucfirst($syntax).'.php';
        if (class_exists($clName)) {
            $class = new $clName($this->app);
            if ($class instanceof Renderer) {
                return $class;
            } else {
                throw new DocumentationProviderException('Renderer must implement '.__NAMESPACE__.'\Renderer');
            }
        } else {
            throw new DocumentationProviderException('Class '.$clName.' does not exists');
        }
    }
}