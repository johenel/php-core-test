<?php 

namespace app\Http\Controllers; 

include('app/Http/Models/Model.php');

class Controller 
{
    protected $request;

    public function __construct()
    {
        $request = collect($_REQUEST);
        
        foreach ($request as $key => $value) {
            $request[$key] = strip_tags($value);
        }

        $this->request = $request;
    }
}