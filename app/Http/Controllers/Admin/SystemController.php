<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Process;

class SystemController extends Controller
{
    /** Run a git command inside the project root; never throws. */
    private function git(array $args, int $timeout = 60): array
    {
        try {
            $r = Process::path(base_path())->timeout($timeout)->run(array_merge(['git'], $args));
            return ['ok' => $r->successful(), 'out' => trim($r->output() . $r->errorOutput())];
        } catch (\Throwable $e) {
            return ['ok' => false, 'out' => $e->getMessage()];
        }
    }

    public function index()
    {
        // Git snapshot (no network — fast)
        $branch = $this->git(['rev-parse', '--abbrev-ref', 'HEAD']);
        $commit = $this->git(['rev-parse', '--short', 'HEAD']);
        $last   = $this->git(['log', '-1', '--pretty=format:%s|%cr']);

        $behind   = null;
        $upstream = $this->git(['rev-parse', '--abbrev-ref', '--symbolic-full-name', '@{u}']);
        if ($upstream['ok']) {
            $count = $this->git(['rev-list', '--count', 'HEAD..@{u}']);
            if ($count['ok'] && is_numeric($count['out'])) {
                $behind = (int) $count['out'];
            }
        }

        [$lastSubject, $lastWhen] = array_pad(explode('|', $last['out'], 2), 2, '');

        $git = [
            'available' => $branch['ok'],
            'branch'    => $branch['ok'] ? $branch['out'] : null,
            'commit'    => $commit['ok'] ? $commit['out'] : null,
            'upstream'  => $upstream['ok'] ? $upstream['out'] : null,
            'behind'    => $behind,
            'subject'   => $lastSubject,
            'when'      => $lastWhen,
        ];

        // Migration status
        Artisan::call('migrate:status');
        $migrateStatus  = trim(Artisan::output());
        $pendingCount   = substr_count($migrateStatus, 'Pending');

        // Environment
        $env = [
            'php'      => PHP_VERSION,
            'laravel'  => app()->version(),
            'env'      => app()->environment(),
            'debug'    => config('app.debug'),
            'db_conn'  => config('database.default'),
            'db_name'  => DB::connection()->getDatabaseName(),
        ];

        return view('admin.system', compact('git', 'migrateStatus', 'pendingCount', 'env'));
    }

    /** Fetch remote refs so "updates available" reflects the latest. */
    public function check()
    {
        $r = $this->git(['fetch', '--all', '--prune'], 90);

        return back()
            ->with($r['ok'] ? 'success' : 'error', $r['ok'] ? 'تم فحص التحديثات من GitHub.' : 'تعذّر الفحص — راجع المخرجات.')
            ->with('cmd_title', 'git fetch')
            ->with('cmd_output', $r['out'] ?: 'لا مخرجات.');
    }

    /** Pull the latest code (fast-forward only — safe, never creates merge commits). */
    public function pull()
    {
        $r = $this->git(['pull', '--ff-only'], 180);

        return back()
            ->with($r['ok'] ? 'success' : 'error', $r['ok'] ? 'تم جلب آخر تحديث بنجاح.' : 'فشل جلب التحديث — راجع المخرجات أدناه.')
            ->with('cmd_title', 'git pull --ff-only')
            ->with('cmd_output', $r['out'] ?: 'لا مخرجات.');
    }

    /** Run pending database migrations. */
    public function migrate()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            $out = trim(Artisan::output());
            return back()
                ->with('success', 'تم تحديث قاعدة البيانات (تشغيل الترحيلات).')
                ->with('cmd_title', 'php artisan migrate --force')
                ->with('cmd_output', $out ?: 'لا توجد ترحيلات معلّقة.');
        } catch (\Throwable $e) {
            return back()
                ->with('error', 'فشل تحديث قاعدة البيانات — راجع المخرجات.')
                ->with('cmd_title', 'php artisan migrate --force')
                ->with('cmd_output', $e->getMessage());
        }
    }

    /** Clear + rebuild caches (config/route/view/compiled). */
    public function optimize()
    {
        try {
            Artisan::call('optimize:clear');
            $out = trim(Artisan::output());
            return back()
                ->with('success', 'تم مسح الذاكرة المؤقتة.')
                ->with('cmd_title', 'php artisan optimize:clear')
                ->with('cmd_output', $out ?: 'تم.');
        } catch (\Throwable $e) {
            return back()
                ->with('error', 'فشل مسح الذاكرة المؤقتة.')
                ->with('cmd_title', 'php artisan optimize:clear')
                ->with('cmd_output', $e->getMessage());
        }
    }
}
