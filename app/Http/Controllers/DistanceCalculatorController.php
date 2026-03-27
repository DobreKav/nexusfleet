<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DistanceCalculatorController extends Controller
{
    /**
     * Calculate distance between two locations using OpenStreetMap (Free)
     */
    public function calculate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'origin' => 'required|string',
            'destination' => 'required|string',
        ]);

        try {
            // Get coordinates for origin location
            $originCoords = $this->geocodeLocation($validated['origin']);
            if (!$originCoords) {
                return response()->json([
                    'error' => 'Не можам да го пронајдам почетното место: ' . $validated['origin'],
                ], 400);
            }

            // Get coordinates for destination location
            $destCoords = $this->geocodeLocation($validated['destination']);
            if (!$destCoords) {
                return response()->json([
                    'error' => 'Не можам да го пронајдам крајното место: ' . $validated['destination'],
                ], 400);
            }

            // Calculate distance using Haversine formula (direct line)
            $distanceInKm = $this->haversineDistance(
                $originCoords['lat'],
                $originCoords['lon'],
                $destCoords['lat'],
                $destCoords['lon']
            );

            // Apply a road factor (roads are typically ~1.2-1.3x longer than straight line)
            $roadDistanceInKm = round($distanceInKm * 1.25);

            return response()->json([
                'success' => true,
                'distance' => $roadDistanceInKm,
                'distance_text' => $roadDistanceInKm . ' км (приблизно)',
                'origin' => $originCoords['display_name'],
                'destination' => $destCoords['display_name'],
                'note' => 'Пресметката е приблизна, врз основа на дирeктно растојание помножено со 1.25 за патни услови',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Грешка при пресметување: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Geocode a location name to coordinates using OpenStreetMap Nominatim (Free)
     */
    private function geocodeLocation(string $location): ?array
    {
        // Hardcoded common locations for faster and more reliable results
        $commonLocations = [
            'skopje' => ['lat' => 41.9973, 'lon' => 21.4280, 'display_name' => 'Skopje, North Macedonia'],
            'belgrade' => ['lat' => 44.8176, 'lon' => 20.4634, 'display_name' => 'Belgrade, Serbia'],
            'sofia' => ['lat' => 42.6977, 'lon' => 23.3219, 'display_name' => 'Sofia, Bulgaria'],
            'vienna' => ['lat' => 48.2082, 'lon' => 16.3738, 'display_name' => 'Vienna, Austria'],
            'budapest' => ['lat' => 47.4979, 'lon' => 19.0402, 'display_name' => 'Budapest, Hungary'],
            'athens' => ['lat' => 37.9838, 'lon' => 23.7275, 'display_name' => 'Athens, Greece'],
            'thessaloniki' => ['lat' => 40.6401, 'lon' => 22.9444, 'display_name' => 'Thessaloniki, Greece'],
            'pristina' => ['lat' => 42.6026, 'lon' => 21.1580, 'display_name' => 'Pristina, Kosovo'],
            'bitola' => ['lat' => 41.0085, 'lon' => 21.3133, 'display_name' => 'Bitola, North Macedonia'],
            'kumanovo' => ['lat' => 42.1294, 'lon' => 21.7081, 'display_name' => 'Kumanovo, North Macedonia'],
            'ohrid' => ['lat' => 41.1615, 'lon' => 20.8027, 'display_name' => 'Ohrid, North Macedonia'],
            'tetovo' => ['lat' => 42.0087, 'lon' => 20.9747, 'display_name' => 'Tetovo, North Macedonia'],
            'zalce' => ['lat' => 41.8050, 'lon' => 21.4833, 'display_name' => 'Zalez, North Macedonia'],
            'veles' => ['lat' => 41.7167, 'lon' => 21.7667, 'display_name' => 'Veles, North Macedonia'],
            'negotino' => ['lat' => 41.4817, 'lon' => 21.5583, 'display_name' => 'Negotino, North Macedonia'],
        ];

        $normalizedLocation = strtolower(trim($location));
        
        // Check hardcoded locations
        foreach ($commonLocations as $key => $coords) {
            if (strpos($normalizedLocation, $key) !== false) {
                return $coords;
            }
        }

        // If not in common locations, try OpenStreetMap API
        try {
            $response = Http::timeout(5)->get('https://nominatim.openstreetmap.org/search', [
                'q' => $location,
                'format' => 'json',
                'limit' => 1,
                'accept-language' => 'en',
                'countrycodes' => 'mk,rs,bg,at,hu,gr,xk', // Macedonia, Serbia, Bulgaria, Austria, Hungary, Greece, Kosovo
            ]);

            $results = $response->json();

            if (!empty($results) && isset($results[0])) {
                $result = $results[0];
                return [
                    'lat' => (float) $result['lat'],
                    'lon' => (float) $result['lon'],
                    'display_name' => $result['display_name'] ?? $location,
                ];
            }

            return null;
        } catch (\Exception $e) {
            \Log::error('Geocoding error for location "' . $location . '": ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Calculate distance between two coordinates using Haversine formula
     * Returns distance in kilometers
     */
    private function haversineDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadiusKm = 6371; // Earth's radius in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadiusKm * $c;

        return $distance;
    }
}

