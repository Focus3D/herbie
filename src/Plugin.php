<?php

/**
 * This file is part of Herbie.
 *
 * (c) Thomas Breuss <www.tebe.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Herbie;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Plugin implements EventSubscriberInterface
{

    /**
     * @var Application;
     */
    protected $app;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->config = $app['config'];
        $this->init();
    }

    /**
     * Initializer
     */
    public function init()
    {
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        $methods = get_class_methods(get_called_class());

        $list = [];
        foreach ($methods as $method) {
            if (strpos($method, 'on') === 0) {
                $list[$method] = [$method, 0];
            }
        }

        return $list;
    }

    /**
     * @param array $htmlOptions
     * @return string
     */
    protected function buildHtmlAttributes($htmlOptions = [])
    {
        $attributes = '';
        foreach ($htmlOptions as $key => $value) {
            $attributes .= $key . '="' . $value . '" ';
        }
        return trim($attributes);
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    protected function config($name, $default = null)
    {
        return $this->config->get($name, $default);
    }
}
