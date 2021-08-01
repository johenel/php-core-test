<?php

use Tightenco\Collect\Support\Collection;

use app\Http\Models\Roster;

class PlayerStatisticReport implements Exportable
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
        $players = $players->select(
            [
                'roster.name',
                'player_totals.*',
                '((3pt * 3) + (2pt * 2) + free_throws) as total_points',
                '(case when 3pt_attempted > 0 then (round((3pt / 3pt_attempted), 2) * 100) else 0 end) as 3pt_pct',
                '(case when 2pt_attempted > 0 then (round((2pt / 2pt_attempted), 2) * 100) else 0 end) as 2pt_pct',
                '(case when free_throws_attempted > 0 then (round((free_throws / free_throws_attempted), 2) * 100) else 0 end) as free_throws_pct',
                '(offensive_rebounds + defensive_rebounds) as total_rebounds'
            ]
        );

        $players = $players->join('player_totals', 'roster.id', '=', 'player_totals.player_id');
        
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