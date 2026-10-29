<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Http\Traits\HasConditionalRelations;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class AttendeeController extends Controller implements HasMiddleware
{
    use HasConditionalRelations;

    /** @var list<string> */
    private array $relations = ['user'];

    /**
     * Get the middleware that should be assigned to the controller.
     *
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show', 'update']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Event $event): JsonResource
    {
        Gate::authorize('viewAny', Attendee::class);

        $attendees = $this->loadRelationships(
            $event->attendees()->latest()
        );

        return AttendeeResource::collection(
            $attendees->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event): AttendeeResource
    {
        Gate::authorize('create', Attendee::class);

        $attendee = $this->loadRelationships(
            $event->attendees()->create([
                'user_id' => $request->user()->id,
            ])
        );

        return new AttendeeResource($attendee);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Attendee $attendee): AttendeeResource
    {
        Gate::authorize('view', $attendee);

        return new AttendeeResource(
            $this->loadRelationships($attendee)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Attendee $attendee): ResponseFactory|Response
    {
        if (Gate::denies('delete', $attendee)) {
            abort(403, 'You do not have permission to remove this attendee.');
        }

        $attendee->delete();

        return response(status: 204);
    }
}
