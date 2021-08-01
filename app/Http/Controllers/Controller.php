<?php 

namespace app\Http\Controllers; 

class Controller 
{
    protected $request;

    public function __construct()
    {
        $this->request = collect($_REQUEST);
    }
}