<?php

namespace Tests\Feature;

use App\Models\LogEntry;
use App\Models\LogSystem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_filtered_logs_and_summary(): void
    {
        $cameraSystem = LogSystem::create([
            'name' => 'CameraSystem',
            'description' => null,
            'api_path' => 'camera1234567890',
        ]);
        $sensorSystem = LogSystem::create([
            'name' => 'SensorSystem',
            'description' => null,
            'api_path' => 'sensor1234567890',
        ]);

        LogEntry::create([
            'system_id' => $cameraSystem->id,
            'level' => 'ERROR',
            'message' => 'カメラ異常',
            'received_at' => '2026-06-20 10:00:00',
        ]);
        LogEntry::create([
            'system_id' => $sensorSystem->id,
            'level' => 'INFO',
            'message' => 'センサー正常',
            'received_at' => '2026-06-20 11:00:00',
        ]);

        $response = $this->get('/?system_id='.$cameraSystem->id.'&level=ERROR&sort=received_at_asc');

        $response->assertOk();
        $response->assertViewHas('filters', fn (array $filters): bool => (int) $filters['system_id'] === $cameraSystem->id);
        $response->assertViewHas('systems', fn ($systems): bool => $systems->count() === 2);
        $response->assertViewHas('summary', [
            'systems' => 2,
            'logs' => 2,
            'errors' => 1,
        ]);
        $response->assertSee('カメラ異常');
        $response->assertDontSee('センサー正常');
    }
}
