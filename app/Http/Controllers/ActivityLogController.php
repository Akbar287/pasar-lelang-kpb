<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Member;
use App\Models\Userlogin;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => ['required'],
            'activity' => ['required']
        ]);

        $member = Member::where('member_id', request('member_id'))->first();
        $member->activity_log()->create([
            'activity' => request('activity')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivityLog $activityLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityLog $activityLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityLog $activityLog)
    {
        $request->validate([
            'member_id' => ['required'],
            'activity' => ['required']
        ]);

        $activityLog->update([
            'activity' => request('activity')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();
    }

    public function activityLog(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();

            $user = Userlogin::where('userlogin_id', $apy['sub'])->first();
            $activityLog = ActivityLog::where('member_id', $user->informasi_akun()->first()->member()->first()->member_id)->paginate(request('page'));

            return response()->json([
                'data' => [
                    'activity_log' => $activityLog
                ],
                'message' => 'Activity Log has been catched',
                'status' => 'success'
            ], 200);
            exit;
        } catch (TokenExpiredException $e) {
            return response()->json([
                'data' => [],
                'message' => 'token_expired: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
            exit;
        } catch (TokenInvalidException $e) {
            return response()->json([
                'data' => [],
                'message' => 'token_invalid: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
            exit;
        } catch (JWTException $e) {
            return response()->json([
                'data' => [],
                'message' => 'token_absent: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
            exit;
        }
    }
}
