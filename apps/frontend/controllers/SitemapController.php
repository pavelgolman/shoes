<?php

namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class SitemapController extends Controller
{

    public function xmlAction()
    {
        //    <xhtml:link rel="amphtml" href="http://example.com/dogs/poodles/poodle1.amp.html"/>
        $date = date('c');
        $xml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

  <url>
    <loc>http://rumi.com.ua<loc>
    <lastmod>{$date}</lastmod>
  </url>

XML;

        $shoes      = \Models\Shoes::find();
        foreach($shoes as $s){
            //<xhtml:link rel="amphtml" href="http://example.com/dogs/poodles/poodle1.amp.html"/>
            $xml .= <<<XML
<url>
    <loc>http://rumi.com.ua/shoes/view/{$s->id}<loc>
    <lastmod>{$date}</lastmod>
  </url>
  
XML;

        }
        $xml .= '<urlset>';

        echo $xml;

        $this->view->disable();
    }

}
