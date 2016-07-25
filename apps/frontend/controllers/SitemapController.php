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
    <loc>http://rumi.store</loc>
    <lastmod>{$date}</lastmod>
  </url>

XML;

        $shoes      = \Models\Shoes::find();
        foreach($shoes as $s){
            //<xhtml:link rel="amphtml" href="http://example.com/dogs/poodles/poodle1.amp.html"/>
            $xml .= <<<XML
<url>
    <loc>http://rumi.store{$s->getURL()}</loc>
    <lastmod>{$date}</lastmod>
  </url>

XML;

        }
        $xml .= '</urlset>';

        echo $xml;

        $this->view->disable();
    }

    public function promuaAction(){
        $xml = '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= '<currency code="UAH" rate="1"/>';
        $xml .= '<catalog>';

        $group = \Models\AttributesGroups::findFirstByConst(\Models\AttributesGroups::TYPE);
        foreach($group->attributes as $attribute){
            $xml .= '<category id="'.$attribute->id.'">'.$attribute->name.'</category>';
            $xml .= '</category>';
        }
        $xml .= '</catalog>';
        $xml .= '<items>';

        $shoes      = \Models\Shoes::find();
        foreach($shoes as $s){
            $xml .= '<item id="'.$s->getCode().'" >';
            $xml .= '<name>'.$s->name.'</name>';
            $category_id = null;
            foreach($group->attributes as $attribute){
                if($s->hasAttribute($attribute)){
                    $category_id = $attribute->id;
                    break;
                }
            }
            $xml .= '<categoryId>'.$category_id.'</categoryId>';
            $xml .= <<<PRICE
<price>
{$s->price}
</price>
<prices>
  <price>
    <value>{$s->price}</value>
   <quantity>1</quantity>
  </price>
</prices>
PRICE;
            $xml .= '<image>http://rumi.store/'.$s->mainImage->originalURL.'</image>';
            $xml .= '<vendorCode>'.$s->article.'</vendorCode>';
            $xml .= '<description><![CDATA['.$s->description->description.']]</description>';

            $xml .= '<available>true</available>';

            $xml .= '<keywords>Купить обувь Днепр наличие заказ</keywords>';
            $xml .= '</item>';
        }
        $xml .= '</items>';

        echo $xml;
        $this->view->disable();
    }

}
