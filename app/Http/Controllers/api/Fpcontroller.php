<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\attendances;
use App\Models\Fpattendances;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Fpcontroller extends Controller
{
    public function index()
    {
        return json_encode(['message' => 'FP Controller Index']);
    }

    public function receive(Request $request)
    {
        // Log incoming data for debugging
        Log::info('ZKTeco data received');
       

        $data = $request->all(); // expects array of {user_id, timestamp}

        foreach ($data as $att) {
            Fpattendances::create([
                'user_id' => $att['user_id'],
                'timestamp' => $att['timestamp'],
                'clockdate'    => Carbon::parse($att['timestamp'])->toDateString(),
                'clocktime'    => Carbon::parse($att['timestamp'])->toTimeString(),
            ]);
        }


        return response()->json(['message' => 'Attendances received successfully'], 200);
    }
}
