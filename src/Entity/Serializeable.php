<?php
/**
 * Created by PhpStorm.
 * User: Michal Kolář
 * Date: 19. 5. 2019
 * Time: 20:16
 */

namespace App\Entity;

interface Serializeable
{
    public function serialize();
}