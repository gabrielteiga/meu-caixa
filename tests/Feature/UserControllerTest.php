<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public array $userCPFData = [
        'name'      => 'Example Company',
        'email'     => 'company@example.com',
        'password'  => 'password123',
        'cpf'       => '98712365400',
    ];

    public array $userCNPJData = [
        'name'      => 'Example Company',
        'email'     => 'company@example.com',
        'password'  => 'password123',
        'cnpj'      => '12345678000100',
    ];

    public function test_can_create_pj_user_with_valid_data()
    {
        $response = $this->postJson('/api/users', $this->userCNPJData);
        
        $response->assertCreated()
            ->assertJsonStructure([
                'message',
                'status',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'cnpj'
                ]
            ]);
    }

    public function test_can_create_pf_user_with_valid_data()
    {
        $response = $this->postJson('/api/users', $this->userCNPJData);
        
        $response->assertCreated()
            ->assertJsonStructure([
                'message',
                'status',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'cpf'
                ]
            ]);
    }

    public function test_cannot_create_any_user_without_his_nature_cpf_or_cnpj()
    {
        $response = $this->postJson('/api/users', $this->userCNPJData);
        
        $response->assertStatus(400)
            ->assertJsonStructure([
                'message',
                'status',
                'errors'
            ]);
    }

    public function test_cannot_create_any_user_with_duplicated_email()
    {
        $response = $this->postJson('/api/users', $this->userCNPJData);
        
        $response->assertStatus(400)
            ->assertJsonStructure([
                'message',
                'status',
                'errors'
            ]);
    }
}
