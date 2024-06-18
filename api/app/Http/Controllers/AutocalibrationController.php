<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class AutocalibrationController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        // $request->autocalibration = $request->autocalibration - 10;

        $user->update([
            'autocalibration' => $request->autocalibration,
        ]);
        
        return response()->json(['status' => 'success'], 204);

    }
}
