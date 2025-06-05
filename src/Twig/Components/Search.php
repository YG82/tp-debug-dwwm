<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use App\Repository\TodoRepository;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent]
final class Search
{
    use DefaultActionTrait;

    #[LiveProp(writable: true, url: true)]
    public ?string $query = null;

    public function __construct(private TodoRepository $tr){}

    public function getTodos(): array
    {
        if ($this->query) {
            return $this->tr->findByQuery($this->query);
        }

        return $this->tr->findBy(
            ['is_public' => true], // Uniquement les todos publics
            ['created_at' => 'DESC'], // Ordre descendant 
            10 // Total de todos à récupérer
        );

    }

}
