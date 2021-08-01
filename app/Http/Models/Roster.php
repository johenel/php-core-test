<?php 
namespace app\Http\Models;

include('app/Http/Models/Model.php');

class Roster extends Model
{
    protected $table = 'roster';

    public function getThreePointRanking() 
    {
        $query = "
            SELECT 
                roster.name as player, 
                team.name as team, 
                YEAR(NOW()) - YEAR(roster.dob) - (DATE_FORMAT(NOW(), '%m%d') < DATE_FORMAT(roster.dob, '%m%d')) AS age,
                roster.number,
                roster.pos,
                ROUND(((player_totals.3pt / player_totals.3pt_attempted) * 100),1) AS three_point_percentage,
                player_totals.3pt
            FROM roster
            LEFT JOIN team ON team.code = roster.team_code
            INNER JOIN player_totals ON roster.id = player_totals.player_id
            ORDER BY three_point_percentage DESC
        ";

        return query($query);
    }
}