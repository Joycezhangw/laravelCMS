<?php
declare (strict_types=1);

namespace App\Http\Controllers\Manage;


use App\Services\Repositories\System\Interfaces\IAlbumFile;
use Illuminate\Http\Request;

class Upload extends ManageController
{

    public function doUpload(Request $request, IAlbumFile $albumFileRepo)
    {
        return $albumFileRepo->doLocalUpload($request);
    }

}
