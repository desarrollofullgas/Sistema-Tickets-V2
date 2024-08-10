<?php

namespace App\Exports;

use App\Exports\Sheets\TicketSheet;
use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TicketsExport implements WithMultipleSheets
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new TicketSheet ($this->tickets);

        return $sheets;
    }
 
}