<?php
use Zend\Expressive\Application;
use Zend\Expressive\Container;
use Zend\Expressive\Helper;
use Zend\Expressive\Router;
use Zend\Expressive\Template;

return [

    'services' => [
        'invokables' => [
            Helper\ServerUrlHelper::class => Helper\ServerUrlHelper::class,
            Router\RouterInterface::class => Router\AuraRouter::class,
        ],
        'factories' => [
            Application::class => Container\ApplicationFactory::class,

            // Url helpers
            Helper\UrlHelper::class => Helper\UrlHelperFactory::class,
            Helper\ServerUrlMiddleware::class => Helper\ServerUrlMiddlewareFactory::class,
            Helper\UrlHelperMiddleware::class => Helper\UrlHelperMiddlewareFactory::class,

            // View
            'Zend\Expressive\FinalHandler' => Container\TemplatedErrorHandlerFactory::class,
            Template\TemplateRendererInterface::class => Zend\Expressive\Twig\TwigRendererFactory::class,
        ],
    ],

];