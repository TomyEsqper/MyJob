<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CheckTableStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:table-structure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the structure of the ofertas table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking ofertas table structure...');
        
        if (Schema::hasTable('ofertas')) {
            $columns = Schema::getColumnListing('ofertas');
            $this->info('Columns in ofertas table:');
            foreach ($columns as $column) {
                $this->line("- $column");
            }
        } else {
            $this->error('Table ofertas does not exist!');
        }
        
        $this->info('Checking usuarios table structure...');
        
        if (Schema::hasTable('usuarios')) {
            $columns = Schema::getColumnListing('usuarios');
            $this->info('Columns in usuarios table:');
            foreach ($columns as $column) {
                $this->line("- $column");
            }
        } else {
            $this->error('Table usuarios does not exist!');
        }
    }
}
