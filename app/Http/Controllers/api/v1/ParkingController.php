<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OficialCar;
use App\Models\Parking;
use App\Models\ResidentCar;
use Carbon\Carbon;
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
        $exit        = null;
        $amount      = null;

        if ( ResidentCar::firstWhere('license_plate', $request->license_plate) )
        {
            $category_id = Category::firstWhere('name', 'Resident')->id;
        }

        if ( OficialCar::firstWhere('license_plate', $request->license_plate) )
        {
            $category_id = Category::firstWhere('name', 'Oficial')->id;
            $exit        = Carbon::parse($request->entry)->addHour(2)->format('Y-m-d H:i:s');
            $amount      = 0;
        }

        $parking = Parking::create([
            'license_plate' => $request->license_plate,
            'category_id'   => $category_id,
            'entry'         => $request->entry,
            'exit'          => $exit,
            'amount'        => $amount
        ]);

        return response()->json([
            'message' => 'Nueva entrada registrada con exito',
            'car'     => [
                'license_plate' => $parking->license_plate,
                'entry'         => $parking->entry,
            ],
        ], 200);
    }

    public function exit(Request $request)
    {
        $request->validate([
            'license_plate' => ['required'],
            'exit'         => ['required']
        ]);

        $parking = Parking::firstWhere('license_plate', $request->license_plate);

        if ( ResidentCar::firstWhere('license_plate', $request->license_plate) )
        {
            $parking->exit = $request->exit;
            $parking->amount = $parking->entry->diffInMinutes(Carbon::parse($request->exit)) * 0.05;
            $parking->save();

            return response()->json([
                'message' => 'Salida registrada con exito',
                'car'     => [
                    'license_plate' => $parking->license_plate,
                    'exit'          => $parking->exit,
                ],
            ], 200);
        }

        if ( OficialCar::firstWhere('license_plate', $request->license_plate) )
        {
            $parking->exit = $request->exit;
            $parking->save();

            return response()->json([
                'message' => 'Salida registrada con exito',
                'car'     => [
                    'license_plate' => $parking->license_plate,
                    'exit'          => $parking->exit,
                ],
            ], 200);
        }

        $parking->exit = $request->exit;
        $parking->amount = $parking->entry->diffInMinutes(Carbon::parse($request->exit)) * 0.5;
        $parking->save();

        return response()->json([
            'message' => 'Salida registrada con exito',
            'car'     => [
                'license_plate' => $parking->license_plate,
                'exit'          => $parking->exit,
            ],
        ], 200);
    }

    public function oficial(Request $request)
    {
        $request->validate([
            'license_plate' => ['required']
        ]);

        $oficial_car = OficialCar::create([
            'license_plate' => $request->license_plate
        ]);

        return response()->json([
            'message' => 'Nuevo oficial registrado con exito',
            'car'     => [
                'license_plate' => $oficial_car->license_plate
            ],
        ], 200);
    }

    public function resident(Request $request)
    {
        $request->validate([
            'license_plate' => ['required']
        ]);

        $resident_car = ResidentCar::create([
            'license_plate' => $request->license_plate
        ]);

        return response()->json([
            'message' => 'Nuevo residente registrado con exito',
            'car'     => [
                'license_plate' => $resident_car->license_plate
            ],
        ], 200);
    }
}
