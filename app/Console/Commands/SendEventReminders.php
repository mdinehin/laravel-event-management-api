<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Notifications\EventReminderNotification;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

#[Signature('events:send-reminders')]
#[Description('Send reminder emails to event attendees before the event begins')]
class SendEventReminders extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = Event::with('attendees.user')
            ->whereBetween('starts_at', [now(), now()->addDay()])
            ->get();

        $eventCount = $events->count();
        $eventLabel = Str::plural('event', $eventCount);

        $this->info('Found '.$eventCount.' '.$eventLabel.'.');

        $events->each(function ($event) {
            $event->attendees->each(function ($attendee) use ($event) {
                $this->info('Notifying user #'.$attendee->user->id.'...');

                $attendee->user->notify(new EventReminderNotification($event));
            });
        });

        $this->info('All event reminders sent successfully.');
    }
}
