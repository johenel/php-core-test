<?php 
namespace app\Http\Models;

class Team extends Model
{
    protected $table = 'team';

    public function getThreePointRanking() 
    {
        $query = "
        SELECT 
            team.name,
            ROUND(((SUM(player_totals.3pt) / SUM(player_totals.3pt_attempted)) * 100),2) AS three_point_percentage,
            SUM(player_totals.3pt) AS 3pt,
            SUM((CASE WHEN player_totals.3pt > 0 THEN 1 ELSE 0 END)) AS contributing_players,
            SUM((CASE WHEN player_totals.3pt_attempted > 0 AND player_totals.3pt > 0 THEN 1 ELSE 0 END)) AS attempting_players,
            SUM(CASE WHEN player_totals.3pt_attempted > 0 AND player_totals.3pt = 0 THEN player_totals.3pt_attempted ELSE 0 END) AS attempted_count_with_zero_made_three_pointers
        FROM team

        LEFT JOIN roster ON roster.team_code = team.code
        LEFT JOIN player_totals ON roster.id = player_totals.player_id

        GROUP BY team.name
        ";

        return query($query);
    }
}