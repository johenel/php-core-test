<?php 

namespace app\Http\Controllers; 

include('app/Http/Models/Model.php');

class Controller 
{
    protected $request;

    public function __construct()
    {
        $request = collect($_REQUEST);
        global $mysqli_db;
        
        foreach ($request as $key => $value) {
            $request[$key] = $mysqli_db->real_escape_string(strip_tags($value));
        }

        $this->request = $request;
    }
}