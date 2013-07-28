<?php
/**
 * Fichier Plain.php.
 * 
 * @license Copyright Sqli 
 * @author rgoyard
 * @since 28/07/13 - 09:06
 */

namespace Mimiz\Silex\Provider\Renderer;
require_once __DIR__.'/../Renderer.php';

use Mimiz\Silex\Provider\Renderer;
use Symfony\Component\HttpFoundation\Response;

class Plain implements Renderer{


    const MIME_TYPE = "text/plain";

    public function render($content)
    {
        $response = new Response($content, 200, array('Content-Type'=>'text/plain'));
        return $response;
    }
}