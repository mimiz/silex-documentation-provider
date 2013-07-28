<?php
/**
 * Fichier DocumentationProviderTest.php.
 * 
 * @license Copyright Sqli 
 * @author rgoyard
 * @since 28/07/13 - 11:51
 */
namespace Mimiz\Tests\Silex\Provider;

require_once __DIR__."/../../../../../vendor/autoload.php";
require_once __DIR__."/../../../../../src/mimiz/Silex/Provider/DocumentationProvider.php";

use Mimiz\Silex\Provider\DocumentationProvider;
use Silex\Application;
use Symfony\Component\HttpKernel\Client;

class DocumentationProviderTest extends \PHPUnit_Framework_TestCase{


    protected $app;


    public function setUp()
    {
        $this->app = new Application();

    }

    public function dataProviderSyntax(){
        return array(
            array('plain', "plain", "txt"),
            array('markdown', 'markdown', 'md'),
            array('textile', 'textile', 'txt')
        );
    }

    public function dataProviderHTMLSyntax(){
        return array(
            array('markdown', 'markdown', 'md'),
            array('textile', 'textile', 'txt')
        );
    }

    /**
     * @dataProvider dataProviderSyntax
     * @test
     */
    public function should_work_with_syntax($syntax, $dir, $extension){
        // GIVEN
        $this->app->register(new DocumentationProvider(), array(
           "documentation.dir" => __DIR__."/datas/".$dir,
           "documentation.url" => '/doc',
           "documentation.extension" => $extension,
           "documentation.home"=>'index',
           "documentation.syntax"=>$syntax,
           "documentation.title"=>'My Documentation',
           "documentation.styles" => array('/components/bootstrap/css/bootstrap.min.css'),
           "documentation.scripts" => array('/components/jquery/jquery.min.js','/components/bootstrap/js/bootstrap.min.js')
        ));
        $client = new Client($this->app);
        // WHEN
        $crawler = $client->request('GET', '/doc');
        // THEN
        $this->assertTrue($client->getResponse()->isOk());

        if( $syntax === 'plain'){

            $this->assertContains('text/plain', $client->getResponse()->headers->get('Content-Type'));
            $this->assertEquals(file_get_contents(__DIR__."/datas/".$dir.'/index.'.$extension), $client->getResponse()->getContent());
        } else {
            $this->assertContains('text/html', $client->getResponse()->headers->get('Content-Type'));
            $this->assertCount(1, $crawler->filter("h1"));
        }
    }


    /**
     * @dataProvider dataProviderHTMLSyntax
     * @test
     */
    public function should_use_title_and_resources_if_html($syntax, $dir, $extension){
        // GIVEN
        $this->app->register(new DocumentationProvider(), array(
           "documentation.dir" => __DIR__."/datas/".$dir,
           "documentation.url" => '/doc',
           "documentation.extension" => $extension,
           "documentation.home"=>'index',
           "documentation.syntax"=>$syntax,
           "documentation.title"=>'My Documentation',
           "documentation.styles" => array('/components/bootstrap/css/bootstrap.min.css'),
           "documentation.scripts" => array('/components/jquery/jquery.min.js','/components/bootstrap/js/bootstrap.min.js')
        ));
        $client = new Client($this->app);
        // WHEN
        $crawler = $client->request('GET', '/doc');
        // THEN
        $this->assertTrue($client->getResponse()->isOk());


        $this->assertContains('text/html', $client->getResponse()->headers->get('Content-Type'));
        $this->assertCount(1, $crawler->filter("title"));
        $this->assertCount(1, $crawler->filter("link"));
        $this->assertCount(2, $crawler->filter("script"));

    }
}