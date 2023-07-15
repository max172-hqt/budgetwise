<?php


function dd($value) {
    echo "<pre>";
    echo $value;
    echo "</pre>";
    die();
}

function base_path($path)
{
    return BASE_PATH . $path;
}
