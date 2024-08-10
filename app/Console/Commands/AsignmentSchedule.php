<?php

namespace App\Console\Commands;

use App\Models\MealUsers;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AsignmentSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cambia el status del usuario para que no se le asignen tickets en su horario de comida';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $assignedMeals = MealUsers::with('meal', 'user')->get();

        foreach ($assignedMeals as $assignment) {
            $startTime = Carbon::parse($assignment->meal->start_time);
            $endTime = Carbon::parse($assignment->meal->end_time);

            // Check if the user's status is not 'En viaje' and not 'Inactivo'
            if ($assignment->user->status !== 'En viaje' && $assignment->user->status !== 'Inactivo') {
                if ($now->between($startTime, $endTime)) {
                    $assignment->user->status = 'Hora Comida';
                } else {
                    $assignment->user->status = 'Activo';
                }

                $assignment->user->save();
            }
        }
    }
}
