<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use Illuminate\Http\Request;
use App\Enums\ApproveStatusEnum;
use App\Enums\TicketStatusEnum;
use App\Enums\RoleEnum;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return TicketResource::collection(
            Ticket::when(auth()->user()->role->title == RoleEnum::USER->value, function ($query) {
                        return $query->WHERE('user_id', auth()->user()->id);
                    })
                    ->when($request->status, function ($query) use ($request) {
                        return $query->FilterByStatus($request->status);
                    })
                    ->when($request->approveStatus, function ($query) use ($request) {
                        return $request->approveStatus == ApproveStatusEnum::APPROVED->value
                                ? $query->Approved()
                                : $query->NotApproved();
                    })
                    ->WHERE('ticket_id', 'LIKE', '%'.$request->search.'%')
                    ->orderBy('id', 'DESC')
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
     * @param  \App\Http\Requests\StoreTicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTicketRequest  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
