<?php

it('reports the API health using the public contract', function () {
    $response = $this->getJson('/api/v1/health');

    $response
        ->assertOk()
        ->assertJsonPath('status', 'ok')
        ->assertJsonPath('service', 'comentaro-api')
        ->assertJsonStructure(['status', 'service', 'version', 'timestamp']);
});
