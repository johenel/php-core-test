<?php 

namespace app\Http\Controllers;

use Exporter;
use PlayerReport;
use PlayerStatisticReport;

include('app/Http/Controllers/Controller.php');
include('app/Services/Exports/Exporter.php');
include('app/Services/Reports/PlayerReport.php');
include('app/Services/Reports/PlayerStatisticReport.php');

class ExportController extends Controller 
{
    protected $exporter;

    public function __construct()
    {
        parent::__construct();
        
        $this->exporter = Exporter::class;
    }

    public function exportPlayers()
    {
        $player_report = new PlayerReport($this->request);
        $exporter = new Exporter($player_report);
        
        return $exporter->export();
    }

    public function exportPlayerStatistics()
    {
        $player_report = new PlayerStatisticReport($this->request);
        $exporter = new Exporter($player_report);
        
        return $exporter->export();
    }
}