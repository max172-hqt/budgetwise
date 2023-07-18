<?php

function base_path($path): string
{
    return BASE_PATH . $path;
}

function get_path($uri): string
{
    return parse_url($uri)['path'];
}