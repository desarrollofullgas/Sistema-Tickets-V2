<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class CloseExpiredTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ticket:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Si la fecha actual es igual a la fecha de vencimiento del ticket, entonces cambia a Vencido';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tickets = Ticket::whereNotNull('fecha_cierre')
        ->where([['status', '<>', 'Cerrado'],['status', '<>', 'Por abrir']])
        ->where('fecha_cierre', '<=', Carbon::now())
        ->get();

    foreach ($tickets as $ticket) {
        DB::beginTransaction();
        try {
            $ticket->vencido = 1;
            $ticket->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
    return 0;
    }
}
