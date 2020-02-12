<?php

class View
{

    function render($pageTpl, $base_template, $pageData)
    {
        include VIEW_PATH . $base_template;
    }
}
