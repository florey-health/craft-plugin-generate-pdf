<?php
/**
 * Generate PDF plugin for Craft CMS 3.x
 *
 * Generate a PDF from a template.
 *
 * @link      https://torbensko.com
 * @copyright Copyright (c) 2018 Torben Sko
 */

namespace spg\generatepdf;

use spg\generatepdf\twigextensions\GeneratePdfTwigExtension;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;

use yii\base\Event;

/**
 * Class GeneratePdf
 *
 * @author    Torben Sko
 * @package   GeneratePdf
 * @since     1.0.0
 *
 */
class GeneratePdf extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var GeneratePdf
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Craft::$app->view->registerTwigExtension(new GeneratePdfTwigExtension());

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'generate-pdf',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
