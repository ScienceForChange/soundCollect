<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

test('email can be verified', function () {
    DB::transaction(function () {
        //TODO: solucion temporal, pero mejorarla
        $u = User::factory()->count(1)->for(
            App\Models\ProfileCitizen::factory(), 'profile'
        )->create([
            'email_verified_at' => null,
        ]);
        $user = $u->first();

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
        $response->assertRedirect(config('app.frontend_url').RouteServiceProvider::HOME.'?verified=1');
    });
});

test('email is not verified with invalid hash', function () {
    DB::transaction(function () {
        //TODO: solucion temporal, pero mejorarla
        $u = User::factory()->count(1)->for(
            App\Models\ProfileCitizen::factory(), 'profile'
        )->create([
            'email_verified_at' => null,
        ]);
        $user = $u->first();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong-email')]
        );

        $this->get($verificationUrl);

        expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
    });
});
