<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PatientTest extends TestCase
{
    protected $header = [
        'Accept' => 'application/json'
    ];

    protected $credentials = [
        'email'=>'administrador3@gmail.com',
        'password'=>'admin'
    ];


    public function test_login()
    {
        $response = $this->withHeaders($this->header)->postJson('/api/login', $this->credentials);
        $response->assertJson([
            'success' => true
        ]);
    }

    public function test_create_patient()
    {

    }
}
