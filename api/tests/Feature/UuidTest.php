<?php

use App\Models\User;


test('get user by uuid', function () {
    $user = User::factory()->create();

    $response = $this->get("api/users/$user->uuid");

    $response->assertStatus(200);
});


test('Not get user by ID', function() {
    $user = User::factory()->create();

    $response = $this->get("api/users/$user->id");

    $response->assertNotFound();
});
