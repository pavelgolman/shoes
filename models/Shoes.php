<?php

namespace Models;

use Phalcon\Mvc\Model;

class Shoes extends Model
{

    public $id;

    public $name;

    public $price;

    public $is_hidden;

    public $main_image_id;

    public function initialize()
    {
        $this->hasMany("id", "\Models\ShoesImages", "shoes_id",  array(
            'alias' => 'images'
        ));
        $this->hasOne('main_image_id', "\Models\ShoesImages", 'id', array(
            'alias' => 'mainImage'
        ));

        $this->belongsTo("id", "\Models\ShoesDescriptions", "shoes_id", array(
            'alias' => 'description'
        ));


        $this->hasMany("id", "\Models\AttributesShoes", "shoes_id",  array(
            'alias' => 'attributesShoes'
        ));

        $this->hasManyToMany(
            "id",
            "\Models\AttributesShoes",
            "shoes_id",
            "attributes_id",
            "\Models\Attributes",
            "id",
            array(
                'alias' => 'attributes'
            )
        );
    }

    public function hasAttribute(Attributes $attribute){
        return $this->hasAttributeId($attribute->id);
    }

    public function hasAttributeId($attribute_id){
        foreach($this->attributesShoes as $attributesShoes){
            if($attributesShoes->attributes_id == $attribute_id){
                return true;
            }
        }

        return false;
    }

    public function getCode(){
        return $this->id + 198545;
    }

    public function getURL(){
        return '/'.$this->get_in_translate_to_en($this->name.' в Днепропетровск цена — купить в интернет-магазине RUMI').'-'.(198545 + $this->id);
    }

    public function get_in_translate_to_en($string)
    {
        $string = str_replace(array(' ', "'", '"', '+', '.', '(', ')', '[', ']', "\\", '/'), '-', strtolower($string));

        $replace = array("А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
                "Е"=>"E","е"=>"e","Ё"=>"E","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z","И"=>"I","и"=>"i",
                "Й"=>"I","й"=>"i","К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n","О"=>"O","о"=>"o",
                "П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t","У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f",
                "Х"=>"Kh","х"=>"kh","Ц"=>"Tc","ц"=>"tc","Ч"=>"Ch","ч"=>"ch","Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch",
                "Ы"=>"Y","ы"=>"y","Э"=>"E","э"=>"e","Ю"=>"Iu","ю"=>"iu","Я"=>"Ia","я"=>"ia","ъ"=>"","ь"=>"");


        return iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
    }
}
