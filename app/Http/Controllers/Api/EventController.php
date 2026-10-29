<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Traits\HasConditionalRelations;
use App\Models\Event;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller implements HasMiddleware
{
    use HasConditionalRelations;

    /** @var list<string> */
    private array $relations = ['user', 'attendees', 'attendees.user'];

    /**
     * Get the middleware that should be assigned to the controller.
     *
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
            new Middleware('throttle:60,1', only: ['store', 'update', 'destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        Gate::authorize('viewAny', Event::class);

        $query = $this->loadRelationships(
            Event::query()
        );

        return EventResource::collection(
            $query->latest()->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): EventResource
    {
        Gate::authorize('create', Event::class);

        $event = Event::create([
            ...$request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'starts_at' => 'required|date',
                'ends_at' => 'required|date|after:starts_at',
            ]),
            'user_id' => $request->user()->id,
        ]);

        return new EventResource(
            $this->loadRelationships($event)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): EventResource
    {
        Gate::authorize('view', $event);

        return new EventResource(
            $this->loadRelationships($event)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event): EventResource
    {
        if (Gate::denies('update', $event)) {
            abort(403, 'You do not have permission to modify this event.');
        }

        $event->update(
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'starts_at' => 'sometimes|date',
                'ends_at' => 'sometimes|date|after:starts_at',
            ])
        );

        return new EventResource(
            $this->loadRelationships($event)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): ResponseFactory|Response
    {
        if (Gate::denies('delete', $event)) {
            abort(403, 'You do not have permission to delete this event.');
        }

        $event->delete();

        return response(status: 204);
    }
}
