<?php
/**
 * Fichier Textile.php.
 * 
 * @license Copyright Sqli 
 * @author rgoyard
 * @since 28/07/13 - 19:30
 */

namespace Mimiz\Silex\Provider\Renderer;
use Mimiz\Silex\Provider\HtmlRenderer;
use Netcarver\Textile as Tx;

use Mimiz\Silex\Provider\Renderer;

class Textile extends HtmlRenderer implements Renderer{

    public function render($content)
    {
        $parser = new Tx\Parser('html5');
        $html = $this->getLayoutHead();
        $html .= $parser->textileThis($content);
        $html .= $this->getLayoutFooter();

        return $html;

    }
}