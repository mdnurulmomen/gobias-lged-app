<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenericRPUController extends Controller
{
    public function getMinistries()
    {
        $ministries = $this->initRPUHttp()->post(config('cag_rpu_api.get-office-ministry-list'), ['all' => 1])->json();
        return isSuccess($ministries) ? $ministries['data'] : [];
    }

    public function getMinistryWiseOfficeLayer(Request $request)
    {
        $ministry_id = $request->ministry_id;
        $layer = $this->initRPUHttp()->post(config('cag_rpu_api.get-office-layer-ministry-wise'), ['ministry_id' => $ministry_id])->json();
        dd($layer,$ministry_id);
        return isSuccess($layer) ? $layer['data'] : [];
    }

    public function getMinistryLayerWiseOffice(Request $request)
    {
        $ministry_id = $request->ministry_id;
        $layer_id = $request->layer_id;
        $rp_offices = $this->initRPUHttp()->post(config('cag_rpu_api.get-rp-office-ministry-and-layer-wise'), ['office_ministry_id' => $ministry_id, 'office_layer_id' => $layer_id])->json();
        return isSuccess($rp_offices) ? $rp_offices['data'] : [];
    }
}
