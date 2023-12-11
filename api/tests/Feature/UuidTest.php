<?php

use App\Models\{ User, ProfileCitizen };


test('get user by uuid', function () {
    $user = User::factory()->for(ProfileCitizen::factory(), 'profile')->create();

    $response = $this->get("api/users/$user->uuid");

    $response->assertStatus(200);
});


test('Not get user by ID', function() {
    $user = User::factory()->for(ProfileCitizen::factory(), 'profile')->create();

    $response = $this->get("api/users/$user->id");

    $response->assertNotFound();
});
