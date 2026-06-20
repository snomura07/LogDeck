<?php

namespace Tests\Feature;

use App\Models\LogEntry;
use App\Models\LogSystem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SystemManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_system_index_displays_registered_systems_with_log_counts(): void
    {
        $system = LogSystem::create([
            'name' => 'CameraSystem',
            'description' => 'Front gate camera',
            'api_path' => 'abcd1234efgh5678',
        ]);

        LogEntry::create([
            'system_id' => $system->id,
            'level' => 'INFO',
            'message' => '起動しました。',
            'received_at' => '2026-06-20 09:00:00',
        ]);

        $response = $this->get('/systems');

        $response->assertOk();
        $response->assertSee('CameraSystem');
        $response->assertSee('Front gate camera');
        $response->assertViewHas('systems', fn ($systems): bool => $systems->first()->logs_count === 1);
    }

    public function test_system_can_be_created(): void
    {
        $response = $this->post('/systems', [
            'name' => 'CameraSystem',
            'description' => 'Front gate camera',
        ]);

        $response->assertRedirect('/systems');
        $this->assertDatabaseHas('systems', [
            'name' => 'CameraSystem',
            'description' => 'Front gate camera',
        ]);
    }
}
