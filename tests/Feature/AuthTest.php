<?php

test('login page is accessible', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
