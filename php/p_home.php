<?php

class p_home
{

    public function __construct($action)
    {
        switch ($action) {
            case 'value':
                echo 'Value?';
                break;

            default:
                echo 'Base';
                break;
        }
    }
}
