<?php

use app\Http\Controllers\ExportController;
use app\Http\Controllers\ReportController;
use app\Services\Router;

Router::get('/', ReportController::class, 'index');
Router::get('/export/players', ExportController::class, 'exportPlayers');
Router::get('/export/players/statistics', ExportController::class, 'exportPlayerStatistics');