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
        $csv = "Код_товара,Название_позиции,Ключевые_слова,Описание,Тип_товара,Цена,Валюта,Скидка,Единица_измерения,Минимальный_объем_заказа,Оптовая_цена,Минимальный_заказ_опт,Ссылка_изображения,Наличие,Производитель,Страна_производитель,Номер_группы,Адрес_подраздела,Возможность_поставки,Срок_поставки,Способ_упаковки,Идентификатор_товара,Уникальный_идентификатор,Идентификатор_подраздела,Идентификатор_группы,ID_группы_разновидностей,Название_Характеристики,Измерение_Характеристики,Значение_Характеристики,Название_Характеристики,Измерение_Характеристики,Значение_Характеристики\n";

        $shoes      = \Models\Shoes::find();
        foreach($shoes as $s){
            $values = array(
                $s->artile,
                $s->name,
                'Купить обувь Днепр наличие заказ',
                $s->name,
                'u',
                $s->price,
                'UAH',
                0,
                'шт.',
                1,
                $s->price,
                1,
                'http://rumi.store/'.$s->mainImage->originalURL,
                '+',
                'Rumi',
                'Украина',
                '',
                '',
                99,
                10,
                'коробка',
                $s->getCode(),
                '','','','','','','','','',''
            );

            $csv .= '"'.implode('", ", ', $values).'"'."\n";
        }

        echo $csv;
        $this->view->disable();
    }

}
