<?php

if (!function_exists('getImageUrl')) {
    /**
     * Get image URL with fallback support for multiple paths
     * Supports:
     * - Seeded images: public/games/filename
     * - Admin uploads: storage/games/filename or storage/banners/filename or items/filename
     */
    function getImageUrl($imagePath, $type = 'game') {
        if (!$imagePath) {
            return asset('/placeholder.jpg');
        }
        
        // If path starts with http://, it's a full URL
        if (strpos($imagePath, 'http://') === 0 || strpos($imagePath, 'https://') === 0) {
            return $imagePath;
        }
        
        // 1. Handle storage/ prefix paths (games, banners uploaded by admin)
        // Path like: storage/games/filename or storage/banners/filename
        if (strpos($imagePath, 'storage/') === 0) {
            // The file is in storage/app/public/{rest of path}
            $storagePath = str_replace('storage/', '', $imagePath);
            if (file_exists(storage_path('app/public/' . $storagePath))) {
                return asset('storage/' . $storagePath);
            }
        }
        
        // 2. Handle items/ or other direct paths (uploaded items without storage prefix)
        // Path like: items/filename
        if (file_exists(storage_path('app/public/' . $imagePath))) {
            return asset('storage/' . $imagePath);
        }
        
        // 3. Check if file exists in public folder (seeded images)
        if (file_exists(public_path($imagePath))) {
            return asset($imagePath);
        }
        
        // 4. Try with common prefixes in public folder
        $publicPrefixes = ['games/', 'banner/', 'images/', 'items/', 'MetodePembayaran/'];
        foreach ($publicPrefixes as $prefix) {
            if (file_exists(public_path($prefix . $imagePath))) {
                return asset($prefix . $imagePath);
            }
        }
        
        // 5. Try with storage prefixes (in case filename was stored without directory)
        $storagePrefixes = ['games/', 'banners/', 'items/', 'images/', 'payment-methods/', 'notifications/'];
        foreach ($storagePrefixes as $prefix) {
            if (file_exists(storage_path('app/public/' . $prefix . $imagePath))) {
                return asset('storage/' . $prefix . $imagePath);
            }
        }
        
        // Fallback to placeholder
        return asset('/placeholder.jpg');
    }
}
