<?php
/**
 * Generate PDF plugin for Craft CMS 3.x
 *
 * Generate a PDF from a template.
 *
 * @link    https://torbensko.com
 * @copyright Copyright (c) 2018 Torben Sko
 */

namespace spg\generatepdf\twigextensions;

use spg\generatepdf\GeneratePdf;
// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

use Craft;

/**
 * @author  Torben Sko
 * @package   GeneratePdf
 * @since   1.0.0
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
  public function generatePdfFunction($templateHtml, $data, $backgroundImage = '')
  {
    $backgroundImage = preg_replace("/[#?].*$/", "", $backgroundImage);
    $subsitutions = explode("\n", $data);

    foreach($subsitutions as $keyValue) {
      if (preg_match("/=/", $keyValue)) {
        $parts = explode("=", $keyValue, 2);
        $templateHtml = preg_replace("/{{[ ]*".$parts[0]."[ ]*}}/", $parts[1], $templateHtml);
      }
    }

    // return $backgroundImage;
    $html = "";
    $html .= "<html><head><link href=\"https://fonts.googleapis.com/css?family=Montserrat\" rel=\"stylesheet\"><style>html,body { margin:0; font-family: 'Montserrat', sans-serif; font-weight: 900; }</style></head><body>";
    $html .= "<div style=\"position:absolute; left:0; right:0; width:100%; height:100%; background-size:cover; background-position:50%; background-image:url('{$backgroundImage}');\">{$templateHtml}</div>";
    $html .= "</body></html>";

    // instantiate and use the dompdf class
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    // $options->set('defaultFont', 'Courier');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();
    $dompdf->stream();
    return '';
  }
}
