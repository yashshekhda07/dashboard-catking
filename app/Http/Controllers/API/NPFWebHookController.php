<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\NpfWebhook;
use Illuminate\Http\Request;

class NPFWebHookController extends Controller
{
    public function store(Request $request)
    {
        $data = NpfWebhook::updateOrCreate([
            'lead_id' => $request->lead_id,
        ], [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'urd' => $request->urd,
            'origin' => $request->origin,
            'source' => $request->source,
            'medium' => $request->medium,
            'campaign' => $request->campaign,
            'stage' => $request->stage,
            'owner' => $request->owner,
            'traffic' => $request->traffic,
        ]);
        if ($data->wasRecentlyCreated) {
            return response()->json(['status' => 'success', 'action' => 'add']);
        }
        return response()->json(['status' => 'success', 'action' => 'update']);
    }
}
