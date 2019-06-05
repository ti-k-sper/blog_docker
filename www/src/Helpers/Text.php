<?php
namespace App\Helpers;

class Text
{
    //              Text::excerpt($post->getContent(), 200)
    public static function excerpt(string $content, int $limit = 100): string
    {
        //mb => pour œ -> 1 caractere
        if(mb_strlen($content) <= $limit){
            return $content;
        }
        $lastSpace = mb_strpos($content, ' ', $limit);//pour ne pas couper les mots
        return mb_substr($content, 0, $lastSpace) . '...';
    }
}