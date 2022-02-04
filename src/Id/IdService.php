<?php
declare(strict_types=1);

namespace LessDomain\Id;

use LessValueObject\String\Format\Resource\Id;

interface IdService
{
    public function generate(): Id;
}
