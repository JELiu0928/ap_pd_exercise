<?php 
namespace App\Helpers;

class PreviewUrl
{
   private static $urlList = [
       // about
       21 => [
            25 => 'about/strategy',
            26 => 'about/strategy',
            30 => 'about/history',
            31 => 'about/history',
            29 => 'about/team'
       ],

       // news
       48 => 'news',

       // brand
       5 => 'brands',
       27 => 'brands',

       // csr
       2 => [
           3 => 'csr',
           8 => 'csr/article',
           9 => 'csr/article',
           10 => 'csr/article',
           12 => 'csr/stakeholder',
           13 => 'csr/stakeholder',
           20 => 'csr/culture',
           15 => 'csr/culture',
           16 => 'csr/culture',
           18 => 'csr/culture',
           19 => 'csr/culture',
       ], 

       // investor
       37 => [
           38 => 'investor',
           39 => 'investor/profile',
           41 => 'investor/finance',
           42 => 'investor/finance',
           43 => 'investor/finance',
           45 => 'investor/governance',
           51 => 'investor/governance',
           54 => 'investor/governance',
           57 => 'investor/governance',
           58 => 'investor/governance',
           60 => 'investor/governance',
           63 => 'investor/shareholder',
           66 => 'investor/shareholder',
           68 => 'investor/message',
           69 => 'investor/message',
           71 => 'investor/stock',
           73 => 'investor/contact',
       ], 

       // knowledge
       33 => 'knowledge',

       // contact
       55 => 'contact'
   ];

   public static function getPreviewUrl($parent = null, $kid = null)
   {
       if (! $parent) return '';

       $list = static::$urlList;

       if (! empty($list[$parent])) {

           if (is_array($list[$parent])) {

               return $list[$parent][$kid] ?? '';

           } else {

               return $list[$parent];

           }

       }
   }
}