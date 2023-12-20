<?php

use App\Models\{ User };
use Illuminate\Support\Facades\DB;

test('users can authenticate using the login screen', function () {

    DB::transaction(function () {
        //TODO: solucion temporal, pero mejorarla
        $user = User::factory()->count(1)->for(
            App\Models\ProfileCitizen::factory(), 'profile'
        )->create();

        $response = $this->post('/login', [
            //TODO: Horrible esto
            'email' => $user->first()->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertCreated();
    });
});

test('users can not authenticate with invalid password', function () {
    DB::transaction(function () {
        //TODO: solucion temporal, pero mejorarla
        $user = User::factory()->count(1)->for(
            App\Models\ProfileCitizen::factory(), 'profile'
        )->create();

        $this->post('/login', [
            'email' => $user->first()->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    });
});

test('users can logout', function () {
    DB::transaction(function () {
        //TODO: solucion temporal, pero mejorarla
        $user = User::factory()->count(1)->for(
            App\Models\ProfileCitizen::factory(), 'profile'
        )->create();

        $response = $this->actingAs($user->first())->post('/logout');

        $this->assertGuest();
        $response->assertNoContent();
    });
});
