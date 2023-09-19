<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use App\Enums\TicketStatusEnum;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return ($request->has('compact')) 
                ? UserResource::collection(User::query()->get())
                : UserResource::collection(
                    User::orderBy('id', 'DESC')
                    ->paginate(config('app.pagination')) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return UserResource::collection(User::query()->WHERE('id', $id)->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showWithCoopTickets($id) {
        $user = User::query()
                ->with(['role', 'userDetail', 'coopTerms.ministry'])
                ->withCount(['coopTerms'])
                ->WHERE('id', $id)
                ->get();

        if($user->isEmpty()){
            return response()->json([
                'data' => $user,
            ]);
        }

        $coopDuration = 0;
        foreach ($user[0]->coopTerms as $term) {
            $start = Carbon::create($term->term_start);
            $end = Carbon::create($term->term_end);
            $coopDuration += $start->diffInDays($end);
        }
        
        $ticketCaseCounts = [];
        foreach (TicketStatusEnum::cases() as $case) {
            $ticketCaseCounts[$case->value] = Ticket::where('status', $case->value)
                                    ->where('user_id', $id)->count();
        };
        $user[0]['ticketCaseCounts'] = $ticketCaseCounts;
        $user[0]['coopDuration'] = $this->convert($coopDuration);
        $user[0]['coopDurationInDays'] = $coopDuration;
        return response()->json([
            'data' => $user,
        ]);
    }

    private function convert($sum) {
        $years = floor($sum / 365);
        $months = floor(($sum - ($years * 365))/30.5);
        $days = ($sum - ($years * 365) - ($months * 30.5));
        $str = "";
        if($years > 0) {
            $str .= $years . " year";
        }
        if($months > 0) {
            $str .= $months. " months";
        }
        return $str;
    }
}
