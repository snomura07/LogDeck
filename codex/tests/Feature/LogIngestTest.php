<?php

namespace Tests\Feature;

use App\Models\LogSystem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogIngestTest extends TestCase
{
    use RefreshDatabase;

    public function test_log_can_be_ingested_with_valid_path(): void
    {
        $system = LogSystem::create([
            'name' => 'CameraSystem',
            'description' => null,
            'api_path' => 'abcd1234efgh5678',
        ]);

        $response = $this->postJson('/api/logs/'.$system->api_path, [
            'level' => 'INFO',
            'message' => '起動しました。',
        ]);

        $response->assertOk()->assertJson(['result' => 'ok']);
        $this->assertDatabaseHas('logs', [
            'system_id' => $system->id,
            'level' => 'INFO',
            'message' => '起動しました。',
        ]);
    }
}
