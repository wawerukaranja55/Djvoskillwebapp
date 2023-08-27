<?php

namespace App\Console\Commands;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Console\Command;

class DeleteUnplacedOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unplacedorder:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Unplaced orders from the database in the cart table after a day ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //delete orders that have not been placed in the carts table and unpaid orders in the orders table
        Cart::where(['is_order'=>'order_placed'])->delete();

        Order::where(['order_status'=>'Unpaid'])->delete();

        $this->info('Order Have been deleted successfully.');
    }
}
