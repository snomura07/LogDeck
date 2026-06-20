<?php

namespace Database\Seeders;

use App\Models\LogEntry;
use App\Models\LogSystem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $camera = LogSystem::create([
            'name' => 'CameraSystem',
            'description' => '監視カメラのイベントログ',
            'api_path' => 'abcd1234efgh5678',
        ]);

        $sensor = LogSystem::create([
            'name' => 'SensorNode',
            'description' => '温度センサー群の監視ログ',
            'api_path' => 'wxyz1234mnop5678',
        ]);

        $entries = [
            [$camera->id, 'INFO', '起動しました。', 0],
            [$camera->id, 'WARN', 'プロセス起動中です。', 2],
            [$sensor->id, 'ERROR', '接続に失敗しました。', 4],
        ];

        foreach ($entries as [$systemId, $level, $message, $minutes]) {
            LogEntry::create([
                'system_id' => $systemId,
                'level' => $level,
                'message' => $message,
                'received_at' => Carbon::now()->subMinutes($minutes),
            ]);
        }
    }
}
