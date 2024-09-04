<?php

namespace App\Console\Commands;

use App\Mail\BookReturnEmail;
use App\Models\BorrowModel;
use App\Models\VisitorsModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendBookReturnCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-book-return-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email when due date ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $all_visitors = VisitorsModel::query()
            ->with(['borrow', 'borrow.books'])
            ->whereHas('borrow', function ($query) {
                $query->whereBetween('due_date', [Carbon::today()->toDateString(), Carbon::today()->addDay(15)->toDateString()])
                ->where('book_return',0);
            })
            ->get();

        foreach ($all_visitors as $visitor) {
            echo $visitor->email;
            Mail::to($visitor->email)->send(new BookReturnEmail($visitor->borrow));
        }
    }
}
