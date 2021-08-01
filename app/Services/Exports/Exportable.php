<?php

use Tightenco\Collect\Support\Collection;

interface Exportable
{
    public function query(): void;
    
    public function getData(): Collection;
    
    public function getFormat(): string;
}