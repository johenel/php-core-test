<?php

use Tightenco\Collect\Support\Collection;

include('app/Services/Exports/Exportable.php');
include('app/Http/Models/Roster.php');

use app\Http\Models\Roster;

class PlayerReport implements Exportable
{
    protected $request;
    protected $data;

    public function __construct(Collection $request)
    {
        $this->request = $request;
        $this->query();
    }

    public function query(): void
    {
        $players = new Roster;
        
        // Filter by player id
        if ($this->request->has('playerId')) {
            $players = $players->where('id', '=', $this->request->get('playerId'));
        }
        // Filter by player name
        if ($this->request->has('player')) {
            $players = $players->where('name', '=', $this->request->get('player'));
        }
        // Filter by team
        if ($this->request->has('team')) {
            $players = $players->where('team_code', '=', $this->request->get('team'));
        }
        // Filter by position
        if ($this->request->has('position')) {
            $players = $players->where('position', '=', $this->request->get('position'));
        }
        // Filter by country
        if ($this->request->has('country')) {
            $players = $players->where('nationality', '=', $this->request->get('country'));
        }

        $this->data = $players->get();
    }

    public function getData(): Collection
    {
        return $this->data;
    }

    public function getFormat(): string
    {
        return $this->request->pull('format') ?: 'html';
    }
}