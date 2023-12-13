<?php

use App\Models\{ User, ProfileCitizen };
use Illuminate\Testing\Fluent\AssertableJson;


test('user should not contain email if the logged user is different than requested', function () {
    $userLogged = User::factory()->for(ProfileCitizen::factory(), 'profile')->create();
    $userRequested = User::factory()->for(ProfileCitizen::factory(), 'profile')->create();

    $response = $this->actingAs($userLogged)->getJson("/api/users/". $userRequested->uuid);

    $response->assertJson(function (AssertableJson $json) {
        $json->has('data.attributes')->missing('email');
    });
});


test('user should see his email if he is requesting his own url', function() {
    $userLogged = User::factory()->for(ProfileCitizen::factory(), 'profile')->create();

    $response = $this->actingAs($userLogged)->getJson("/api/users/$userLogged->uuid");

    $response->assertJson(function (AssertableJson $json) {
        $json->has('data.attributes.email');
    });
});
