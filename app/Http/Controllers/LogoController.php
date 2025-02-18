<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        Log::info('Update logo request received.');

        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);
        Log::info('Validation passed for logo upload.');

        if ($request->hasFile('logo')) {
            try {
                $file = $request->file('logo');
                $filename = 'logo.png';
                $path = 'images/logo';

                Storage::disk('public')->putFileAs(
                    $path,
                    $file,
                    $filename
                );

                Log::info('Logo uploaded successfully.', ['filename' => $filename, 'path' => $path]);
                return back()->with('success', 'Данные успешно сохранены.');
            } catch (Exception $e) {
                Log::error('Error while uploading logo.', [
                    'error_message' => $e->getMessage(),
                    'filename' => $filename,
                    'path' => $path,
                ]);
                return back()->with('error', 'Не удалось загрузить файл.');
            }
        }

        Log::warning('No logo file found in the request.');
        return back()->with('error', 'Не удалось загрузить файл.');
    }
}
