<?php
/**
 * Fichier Markdown.php.
 *
 * @license Copyright Sqli
 * @author  rgoyard
 * @since   28/07/13 - 09:02
 */

namespace Mimiz\Silex\Provider\Renderer;
require_once __DIR__ . '/../Renderer.php';
require_once __DIR__ . '/../HtmlRenderer.php';

use Michelf\MarkdownExtra;
use Mimiz\Silex\Provider\HtmlRenderer;
use Mimiz\Silex\Provider\Renderer;
use Silex\Application;

class Markdown extends HtmlRenderer implements Renderer
{


    const MIME_TYPE = "text/html";


    public function render($content)
    {
        $html = $this->getLayoutHead();
        $html .= MarkdownExtra::defaultTransform($content);
        $html .= $this->getLayoutFooter();

        return $html;
    }


}