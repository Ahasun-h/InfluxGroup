<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class StorageController extends Controller
{
    /**
     * Run the storage:link command and return status
     */
    public function createLink()
    {
        try {
            // Create output buffer to capture command output
            $output = new BufferedOutput();

            // Run the storage:link command
            Artisan::call('storage:link', [], $output);

            // Get the command output
            $commandOutput = $output->fetch();

            // Check if the symlink was created successfully
            $storageLinkExists = file_exists(public_path('storage'));

            if ($storageLinkExists) {
                return response()->json([
                    'success' => true,
                    'message' => 'Storage link created successfully',
                    'output' => $commandOutput,
                    'symlink_path' => public_path('storage'),
                    'target_path' => storage_path('app/public')
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Storage link creation failed',
                    'output' => $commandOutput
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating storage link: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Serve storage files when nginx doesn't follow symlinks
     */
    public function serve($folder, $filename)
    {
        try {
            $path = $folder . '/' . $filename;

            if (!Storage::disk('public')->exists($path)) {
                abort(404, 'File not found');
            }

            $file = Storage::disk('public')->get($path);
            $mimeType = Storage::disk('public')->mimeType($path);

            return response($file, 200)->header('Content-Type', $mimeType);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to serve file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Alias method for backward compatibility
     */
    public function show()
    {
        return $this->createLink();
    }
}
