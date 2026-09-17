<?php

namespace App\Services;

use App\Models\SiteProfile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class SiteProfileWriter
{
    public function save(array $data): SiteProfile
    {
        $profile = SiteProfile::current();
        $profile->id = 1;
        $newPaths = [];
        $oldPaths = [];
        try {
            foreach (['hero', 'about'] as $section) {
                $key = $section.'_photo';
                if (! empty($data[$key])) {
                    $path = $data[$key]->store('profiles', 'public');
                    if ($path === false) {
                        throw new RuntimeException('Gagal menyimpan foto.');
                    }
                    $newPaths[] = $path;
                    $oldPaths[] = $profile->$key;
                    $data[$key] = $path;
                } elseif (! empty($data['remove_'.$key])) {
                    $oldPaths[] = $profile->$key;
                    $data[$key] = null;
                } else {
                    unset($data[$key]);
                }
            }
            DB::transaction(function () use ($profile, $data): void {
                $profile->fill(Arr::except($data, ['remove_hero_photo', 'remove_about_photo', 'hero_roles_text']))->save();
            });
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($newPaths);
            throw $exception;
        }
        foreach ($oldPaths as $path) {
            if ($path && str_starts_with($path, 'profiles/') && ! in_array($path, [$profile->hero_photo, $profile->about_photo], true)) {
                Storage::disk('public')->delete($path);
            }
        }

        return $profile;
    }
}
