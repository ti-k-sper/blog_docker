<?php
namespace App\Helpers;

class Text
{
    //              Text::excerpt($post->getContent(), 200)
    public static function excerpt(string $content, int $limit = 100): string
    {
        //"#<.+>.+</.+>#isU" => pour detecter les toutes les balises html
        if(preg_match("#<.+>.+</.+>#isU", $content)){
            $content = strip_tags($content);
        }
        //mb => pour œ -> 1 caractere
        if(mb_strlen($content) <= $limit){
            return $content;
        }
        $lastSpace = mb_strpos($content, ' ', ($limit -1));//pour ne pas couper les mots
        if(empty($lastSpace)){
            return mb_substr($content, 0, $limit) . '...';
        }
        return mb_substr($content, 0, $lastSpace) . '...';
    }
}