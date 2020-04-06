<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PagesTest extends TestCase
{
    public function test_get_home()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Welcome to the Covid Collective');
    }

    public function test_resources()
    {
        $response = $this->get('/resources');

        $response->assertStatus(200);
        // TODO: Seed some resources :facepalm
        $response->assertSee('Sorry, no resources matched your search.', false);
        $response->assertSee('Anyone', false);
    }

    public function test_volunteer()
    {
        $response = $this->get('/volunteer');

        $response->assertStatus(200);
        $response->assertSee('We\'re working on tools to help people support those in need', false);
    }

    public function test_help()
    {
        $response = $this->get('/ways-to-help');

        $response->assertStatus(200);
        $response->assertSee('2. Track your symptoms', false);
    }

    
}
