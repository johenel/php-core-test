<?php 
namespace app\Http\Controllers;

include('app/Http/Controllers/Controller.php');
include('app/Http/Models/Team.php');
include('app/Http/Models/Roster.php');

use app\Http\Controllers\Controller;
use app\Http\Models\Team;
use app\Http\Models\Roster;

class ReportController extends Controller
{
    protected $team_model;
    protected $player_model;

    public function __construct()
    {
        $this->team_model = new Team;
        $this->player_model = new Roster;
    }

    public function index()
    {
        $ranked_three_point_players =  $this->player_model->getThreePointRanking();
        $ranked_three_point_teams =  $this->team_model->getThreePointRanking();

        return view('home', compact('ranked_three_point_players', 'ranked_three_point_teams'));
    }
}