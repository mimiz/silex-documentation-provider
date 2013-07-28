<?php
/**
 * Fichier HtmlRenderer.php.
 * 
 * @license Copyright Sqli 
 * @author rgoyard
 * @since 28/07/13 - 19:46
 */

namespace Mimiz\Silex\Provider;


use Silex\Application;

abstract class HtmlRenderer {

    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }


    protected function getLayoutHead()
    {
        $html = "<!DOCTYPE html>\n<html>\n";
        $html .= "  <head>\n";
        $html .= "    <title>".$this->app["documentation.title"]."</title>\n";
        $html .= $this->insertStyles();
        $html .= "  </head>\n  <body>\n";
        $html .= "    <div class='row-fluid'><div class='span10 offset1'>";
        return $html;
    }

    protected function getLayoutFooter()
    {
        $html = $this->insertScripts();
        $html .= "</div></div>\n</body>\n</html>";
        return $html;
    }

    protected function insertStyles()
    {
        $buff = '';
        if( is_array($this->app["documentation.styles"]) ){
            foreach ($this->app["documentation.styles"] as $style) {
                $buff .= '    <link rel="stylesheet" type="text/css" href="'.$style.'">'."\n";
            }
        }
        return $buff;
    }

    protected function insertScripts()
    {
        $buff = '<!-- [Scripts] -->'."\n";
        if( is_array($this->app["documentation.scripts"]) ){
            foreach ($this->app["documentation.scripts"] as $style) {
                $buff .= '    <script src="'.$style.'"></script>'."\n";
            }
        }
        $buff .= '<!-- [/Scripts] -->'."\n";
        return $buff;
    }
}