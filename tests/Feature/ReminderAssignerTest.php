<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReminderAssignerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testEndPoint()
    {
	$response = $this->json('POST', '/api/module_reminder_assigner', ['contact_email' => 'carlos.harvey@example.com']);

	$response->assertStatus(204);
    }
}
