<?php

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'birth_year' => '31-12-1993',
        'gender' => 'hombre'
    ]);

    $this->assertAuthenticated();
    $response->assertNoContent();
});
