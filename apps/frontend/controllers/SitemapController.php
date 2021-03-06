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
    <loc>http://mnogoobuvi.com</loc>
    <lastmod>{$date}</lastmod>
  </url>

XML;

        $shoes      = \Models\Shoes::find();
        foreach($shoes as $s){
            //<xhtml:link rel="amphtml" href="http://example.com/dogs/poodles/poodle1.amp.html"/>
            $xml .= <<<XML
<url>
    <loc>http://mnogoobuvi.com{$s->getURL()}</loc>
    <lastmod>{$date}</lastmod>
  </url>

XML;

        }
        $xml .= '</urlset>';

        echo $xml;

        $this->view->disable();
    }

    public function promuaAction(){
        $xml = '<?xml version="1.0" encoding="utf-8"?>'."\n";
        $xml .= '<price date="'.date('Y-m-d H:i').'">'."\n";
        $xml .= '<name>mnogoobuvi.com</name>'."\n";
        $xml .= '<currency code="USD">1.00</currency>'."\n";
        $xml .= '<catalog>'."\n";

        $group = \Models\AttributesGroups::findFirstByConst(\Models\AttributesGroups::TYPE);
        foreach($group->attributes as $attribute){
            $xml .= '<category id="'.$attribute->id.'">'.$attribute->name.'</category>'."\n";
        }
        $xml .= '</catalog>'."\n";
        $xml .= '<items>'."\n";

        $shoes      = \Models\Shoes::find();
        foreach($shoes as $s){
            $xml .= '<item id="'.$s->getCode().'" selling_type="u">'."\n";
            $xml .= '<name>'.$s->name.'</name>'."\n";
            $category_id = null;
            foreach($group->attributes as $attribute){
                if($s->hasAttribute($attribute)){
                    $category_id = $attribute->id;
                    break;
                }
            }
            $xml .= '<categoryId>'.$category_id.'</categoryId>'."\n";
            $xml .= '<price>'.$s->price.'</price>'."\n";
            $xml .= '<image>http://mnogoobuvi.com'.$s->mainImage->originalURL().'</image>'."\n";
            $xml .= '<description><![CDATA['.$s->description->description.']]></description>'."\n";

            $xml .= '<available>true</available>'."\n";

            $xml .= '<keywords>Купить обувь Днепр наличие заказ</keywords>'."\n";
            $xml .= '</item>'."\n";
        }
        $xml .= '</items>'."\n";
        $xml .= '</price>'."\n";

        echo $xml;
        $this->view->disable();
    }

}
