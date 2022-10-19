<?php

namespace App\Jobs;

use App\Models\Message;
use App\Models\Thread;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyNewMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The message to notify
     *
     * @var Message $message
     */
    public Message $message;

    /**
     * Initial time of triggering this message
     *
     * @var ?Carbon $initTime
     */
    public ?Carbon $initTime = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->initTime = Carbon::now();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Fetch the related thread
        $thread = $this->message->thread;
        $latestMessage = $thread->messages->whereNull('notified')->sortByDesc('created_at')->first();
        $latestId = $latestMessage->id ?? 'unknown';
        if ($this->message->id !== $latestId) {
            $msg = 'Message id ' . $this->message->id . ' will be addressed by ';
            $msg .= 'message id ' . $latestId . ' as it was created later.';
            logger($msg);
            return;
        }
        $this->sendNotifications($thread);
    }

    /**
     * Notify all impacted users
     *
     * @param Thread $thread
     *
     * @return void
     */
    private function sendNotifications(Thread $thread) {
        logger("notify messages now!");
        $messages = $thread->messages->whereNull('notified')->sortBy('created_at');
        $msg = 'the following messages have been recently created: [ ';
        foreach ($messages as $message) {
            $msg .= $message->id . ' ';
            $message->notified = Carbon::now()->timestamp;
            $message->save();
        }
        $msg .= ']';
        foreach ($thread->contributors() as $user) {
            logger($user->name . ', ');
        }
    }
}
