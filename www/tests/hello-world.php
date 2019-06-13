<?php
function helloWorld(string $name="World")
{
    //ucfirst -> 1ere lettre en maj
    return 'Hello, '. ucfirst(strtolower($name)) . '!';
}