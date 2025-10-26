<?php

// app/Filament/Widgets/TriggerGithubActionWidget.php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Http;
use Filament\Notifications\Notification;

class TriggerGithubActionWidget extends Widget
{
    // Gunakan view kustom untuk menampilkan tombol
    protected static string $view = 'filament.widgets.trigger-github-action-widget';

    // Opsi untuk mengatur tampilan grid di dashboard
    protected int | string | array $columnSpan = 1;

    // Metode yang akan dipanggil saat tombol diklik
    public function triggerAction()
    {
        // 1. Ambil konfigurasi dari .env
        $token = config('services.github.token');
        $owner = config('services.github.owner');
        $repo = config('services.github.repo');
        $workflow_id = config('services.github.workflow_id');
        $branch = config('services.github.branch');

        if (!$token || !$owner || !$repo || !$workflow_id) {
            Notification::make()
                ->title('Error Konfigurasi')
                ->body('Pastikan GITHUB_API_TOKEN, GITHUB_REPO_OWNER, GITHUB_REPO_NAME, dan GITHUB_WORKFLOW_ID sudah diatur di .env.')
                ->danger()
                ->send();
            return;
        }

        // 2. Memanggil GitHub API
        $response = Http::withToken($token)
            ->withHeaders([
                'Accept' => 'application/vnd.github.v3+json',
                'X-GitHub-Api-Version' => '2022-11-28',
            ])
            ->post("https://api.github.com/repos/{$owner}/{$repo}/actions/workflows/{$workflow_id}/dispatches", [
                'ref' => $branch, // Branch target
                // 'inputs' => [
                //     'reason' => 'Dipicu dari Dashboard Filament oleh ' . auth()->user()->name,
                // ],
            ]);

        // 3. Tangani respons API
        if ($response->successful() && $response->status() == 204) {
            Notification::make()
                ->title('Aksi Berhasil Dipicu')
                ->body("GitHub Action ({$workflow_id}) berhasil dipicu di branch {$branch}.")
                ->success()
                ->send();
        } else {
            // Log respons untuk debugging
            \Log::error('Gagal memicu GitHub Action.', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            Notification::make()
                ->title('Gagal Memicu Aksi')
                ->body('Terjadi kesalahan saat menghubungi GitHub API. Cek log server.')
                ->danger()
                ->send();
        }
    }
}