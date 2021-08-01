<?php 

namespace app\Http\Models;

class Model 
{
    protected $query;

    public function get()
    {
        return query($this->query);
    }
}