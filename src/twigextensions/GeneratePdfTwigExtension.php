<?php
/**
 * Generate PDF plugin for Craft CMS 3.x
 *
 * Generate a PDF from a template.
 *
 * @link      https://torbensko.com
 * @copyright Copyright (c) 2018 Torben Sko
 */

namespace spg\generatepdf\twigextensions;

use spg\generatepdf\GeneratePdf;

use Craft;

/**
 * @author    Torben Sko
 * @package   GeneratePdf
 * @since     1.0.0
 */
class GeneratePdfTwigExtension extends \Twig_Extension
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'GeneratePdf';
    }

    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('generatePdf', [$this, 'generatePdfFunction']),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('someFunction', [$this, 'generatePdfFunction']),
        ];
    }

    /**
     * @param null $text
     *
     * @return string
     */
    public function generatePdfFunction($text = null)
    {
        $result = $text." in the way";
        return $result;
    }
}
