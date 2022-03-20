<?php

namespace App\Http\Controllers;

use App\Traits\GenericInfoCollection;
use App\Traits\UserInfoCollector;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, UserInfoCollector, GenericInfoCollection;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $is_logged_in = $this->checkLogin() ? 'true' : 'false';
            view()->share('is_logged_in', $is_logged_in);

            if ($this->checkLogin()) {
                self::viewSharer();
            }
            return $next($request);
        });

    }

    public function viewSharer()
    {
        $wizard = $this->wizard();
        view()->share('wizardData', $wizard);

        $userDetails = $this->getUserDetails();
        view()->share('userDetails', $userDetails);

        $employeeInfo = $this->getEmployeeInfo();
        view()->share('employeeInfo', $employeeInfo);

        $userOffices = $this->getUserOffices();
        view()->share('userOffices', $userOffices);

        $moduleMenus = $this->userPermittedModules();
        view()->share('modules', $moduleMenus);

    }

    public function wizard()
    {
        if (!session('_wizard')) {
//            $http = new \GuzzleHttp\Client(['verify' => false]);
//            $response = $http->get(config('cag_doptor_api.widget'));
            $http = $this->initHttp()->get(config('cag_doptor_api.widget'))->json();
            $data = json_decode($http, true);
            session()->put(['_wizard' => $data['data']]);
            session()->save();
        }
        return session('_wizard');
    }
}
