<?php

namespace CW\CarwashBundle\DataFixtures\ORM;


class Configuration
{
    const USERS = 3;
    const CLIENTS = 5;
    const PROMOTIONS = 4;
    const ORDERS = 20;

    public static $defaultProducts = [
        'inside', 'outside', 'engine', 'detailing', 'rims', 'waxing'
    ];
}
