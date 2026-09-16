<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProvisionAdmin extends Command
{
    protected $signature = 'portfolio:admin {email} {--name=Portfolio Admin}';

    protected $description = 'Create or update the owner account using a hidden password prompt or ADMIN_PASSWORD environment variable';

    public function handle(): int
    {
        $password = getenv('ADMIN_PASSWORD') ?: ($this->input->isInteractive() ? $this->secret('Password') : '');
        $data = ['email' => strtolower(trim($this->argument('email'))), 'password' => $password, 'name' => $this->option('name')];
        $validator = Validator::make($data, ['email' => 'required|email|max:255', 'password' => 'required|string|min:8|max:1024', 'name' => 'required|string|max:255']);
        if ($validator->fails()) {
            $this->error('Email, nama, atau password tidak valid. Password minimal 8 karakter.');

            return self::FAILURE;
        }
        $user = DB::transaction(function () use ($data): User {
            $user = User::firstOrNew(['email' => $data['email']]);
            $user->name = $data['name'];
            $user->password = $data['password'];
            $user->is_admin = true;
            $user->remember_token = Str::random(60);
            $user->save();
            $user->tokens()->delete();
            DB::table('sessions')->where('user_id', $user->id)->delete();

            return $user;
        });
        if (! Hash::check($password, $user->fresh()->password)) {
            $this->error('Verifikasi password gagal.');

            return self::FAILURE;
        }
        $this->info('Akun admin siap; password tersimpan sebagai hash dan berhasil diverifikasi.');

        return self::SUCCESS;
    }
}
