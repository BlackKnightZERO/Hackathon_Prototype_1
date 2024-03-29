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
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Traits\HttpRes;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    use HttpRes;
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
        $storeArr = [
            'ticket_id'     => $request->ticket_id,
            'link'          => $request->link,
            'start_day'     => $request->start_day,
            'end_day'       => $request->end_day,
            'proposed_completion_day'=> $request->proposed_completion_day,
            'status'        => $request->status,
            'user_id'       => $request->user_id,
            'approver_id'   => $request->approver_id,
            'slug'          => SlugService::createSlug(Ticket::class, 'slug', $request->ticket_id, ['unique' => true]),
        ];
        if($request->has('verify_status')) {
            array_merge($storeArr, ['verify_status' => $request->verify_status]);
        }
        $data = Ticket::create($storeArr);

        $ticket = TicketResource::collection(Ticket::WHERE('id', $data->id)->get());

        return $this->success('201', 'Ticket Added Successfully', $ticket[0]);
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
    public function update(UpdateTicketRequest $request, $id)
    {
        $updateArr = [
            'ticket_id'     => $request->ticket_id,
            'link'          => $request->link,
            'start_day'     => $request->start_day,
            'end_day'       => $request->end_day,
            'proposed_completion_day'=> $request->proposed_completion_day,
            'status'        => $request->status,
            'user_id'       => $request->user_id,
            'approver_id'   => $request->approver_id,
            'slug'          => SlugService::createSlug(Ticket::class, 'slug', $request->ticket_id, ['unique' => true]),
        ];
        if($request->has('verify_status')) {
            array_merge($updateArr, ['verify_status' => $request->verify_status]);
        }

        Ticket::where('id', $id)->update($updateArr);
        $ticket = TicketResource::collection(Ticket::where('id', $id)->get());
        return $this->success('202', 'Ticket Updated Successfully', $ticket[0]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ticket::destroy($id);
        return $this->success('200', 'Ticket Deleted Successfully', []);
    }
}
