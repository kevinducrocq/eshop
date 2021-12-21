<?php

function url_for($script)
{
    if ($script[0] != '/') {
        $script = '/' . $script;
    }
    return URLROOT . $script;
}

function redirect($page)
{
    header('Location: ' . URLROOT . '/' . $page);
    exit;
}
