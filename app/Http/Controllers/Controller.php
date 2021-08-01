<?php 

namespace app\Http\Controllers; 

include('app/Http/Models/Model.php');

class Controller 
{
    protected $request;

    public function __construct()
    {
        $this->request = collect($_REQUEST);
    }
}