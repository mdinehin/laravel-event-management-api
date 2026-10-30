<?php

namespace App\Http\Traits;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasConditionalRelations
{
    /**
     * Conditionally load relations onto a Model or Query Builder based on the request.
     *
     * @param  Builder<Event>|Model|HasMany<Attendee, Event>  $target  The model or query builder instance.
     * @param  list<string>|null  $relations  The relations to evaluate and load, or null to fall back to the default property.
     * @return Builder<Event>|Model|HasMany<Attendee, Event> The updated model or query builder instance.
     */
    public function loadRelationships(Model|Builder|HasMany $target, ?array $relations = null): Model|Builder|HasMany
    {
        $relations = $relations ?? $this->relations;

        foreach ($relations as $relation) {
            $target->when(
                $this->shouldIncludeRelation($relation),
                fn (Builder $query) => $target instanceof Model ? $target->load($relation) : $query->with($relation)
            );
        }

        return $target;
    }

    /**
     * Determine whether the given relation should be included based on the request.
     *
     * @param  string  $relation  The name of the relation to check.
     * @return bool True if the relation is requested, false otherwise.
     */
    protected function shouldIncludeRelation(string $relation): bool
    {
        $include = request()->query('include');

        if (! $include) {
            return false;
        }

        $relations = array_map('trim', explode(',', $include));

        return in_array($relation, $relations);
    }
}
