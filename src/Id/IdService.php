<?php
declare(strict_types=1);

namespace LessDomain\Id;

use LessValueObject\String\Format\Reference\Id;

interface IdService
{
    public function generate(): Id;
}
