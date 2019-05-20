<?php
/**
 * Created by PhpStorm.
 * User: Michal Kolář
 * Date: 20. 5. 2019
 * Time: 10:36
 */

namespace App\Entity\Util;

interface TimestampableInterface
{
    public function getUpdatedAt(): ?\DateTime;
    public function getCreatedAt(): ?\DateTime;
}