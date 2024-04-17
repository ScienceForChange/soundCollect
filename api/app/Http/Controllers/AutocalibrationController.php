<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AutocalibrationController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $user->profile()->update([
            'autocalibration' => $request->autocalibration,
        ]);
        
        return response()->json([
            'user' => $user,
        ], 200);

        // return $request->autocalibration;

    }
}
