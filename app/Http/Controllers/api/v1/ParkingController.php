<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OficialCar;
use App\Models\Parking;
use App\Models\ResidentCar;
use Illuminate\Http\Request;

class ParkingController extends Controller
{
    public function entry(Request $request)
    {
        $request->validate([
            'license_plate' => ['required'],
            'entry'         => ['required']
        ]);

        $category_id = Category::firstWhere('name', 'Visitor')->id;

        if ( ResidentCar::firstWhere('license_plate', $request->license_plate) )
        {
            $category_id = Category::firstWhere('name', 'Resident')->id;
        }

        if ( OficialCar::firstWhere('license_plate', $request->license_plate) )
        {
            $category_id = Category::firstWhere('name', 'Oficial')->id;
        }

        $parking = Parking::create([
            'license_plate' => $request->license_plate,
            'category_id'   => $category_id,
            'entry'         => $request->entry
        ]);

        return response()->json([
            'message' => 'Nueva entrada registrada con exito',
            'car'     => [
                'license_plate' => $parking->license_plate,
                'entry'         => $parking->entry,
            ],
        ], 200);
    }
}
