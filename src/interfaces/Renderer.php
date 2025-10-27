<?php
namespace iutnc\deefy\interfaces;
interface Renderer
{
    const COMPACT=1;
    const LONG=2;
    function render(int $mod):string;
}