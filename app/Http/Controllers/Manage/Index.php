<?php
declare (strict_types=1);

namespace App\Http\Controllers\Manage;

class Index extends ManageController
{
    public function index(){
       return $this->view();
    }

}
