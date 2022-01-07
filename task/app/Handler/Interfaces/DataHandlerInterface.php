<?php

declare(strict_types=1);

namespace App\Handler\Interfaces;

use Illuminate\Support\Collection;

interface DataHandlerInterface
{
    /**
     * @return Collection
     */
    public function getData(): Collection;
}
