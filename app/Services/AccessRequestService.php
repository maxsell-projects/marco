<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AccessRequestService
{
    public function approveRequest(User $user): string
    {
        $tempPassword = Str::random(10);

        DB::transaction(function () use ($user, $tempPassword) {
            $user->update([
                'is_active' => true,
                'password' => Hash::make($tempPassword),
                'email_verified_at' => now(),
            ]);
            
            // Aqui dispararíamos eventos para e-mails futuramente
            // event(new UserApproved($user, $tempPassword));
        });

        return $tempPassword;
    }

    public function rejectRequest(User $user): void
    {
        DB::transaction(function () use ($user) {
            if ($user->document_path) {
                Storage::disk('public')->delete($user->document_path);
            }
            $user->delete();
        });
    }
}