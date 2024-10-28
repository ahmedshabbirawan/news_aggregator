<?php

namespace Modules\User\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\User\App\Features\GetPreferencesFeature;
use Modules\User\App\Features\SaveUserPreferencesFeature;
use Modules\User\App\Repositories\PreferencesRepository;

class UserPreferencesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function getPreferencesPageResources(Request $request, GetPreferencesFeature $feature)
    {
        return $feature->_handleApi($request, auth()->user());
    }

    public function savePreferences(Request $request, SaveUserPreferencesFeature $feature)
    {
        return $feature->_handleApi($request, auth()->user());
    }


}
