<?php

namespace App\Repository;
use \App\Transaction;
use \App\MemberTotal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class OrderRepository{

    public function changeStatus(){
        try{
            DB::table('cart')->where('signature', 'RWJweUtKbnV3V2N5aDJhdjlkUUxZR1FQazJLQjdQSjJydlNEYlR5RUZmaFVzV2U2aEN1UWFmbzJhZVk3ekdYSW1uOGp1cDRLVGg5cUNPc1kvOGpKRTZPdGp0R2VIZjB5VDUrSi95N1lieTVqWnNCSW1EK210S2tScHYydzRoRFhpTU5yVjJUcTBuNkNQWUFNMFBxWWVTc1k1bEExcDdVVUxSR29tazVHV0tNL0xlRjFVazU1SE4vUEE5cW5xODFvRDhiSm5PVmFWY1pjL084a1RRY1FPVEg1a1VMSS9LTjNtTmo1UGFHUGlQSVFrYUtMSWJPRkdDODA1UmZvajlkeXprNzVIZXAwYVEzWkxUNXlqeC9hUkxhRU9zMXN4MXhZTUR6Yy9tT05PUnZzdFljUGpGdnRRM1NUalBnS1hJcGN0bTJYM1l6ajY0bVZ5TDVFSnJlT0w2dFlmVE1pWHFoUkcyWXFaRTJML1llVFNZY25Xb1F5Nm9kZ05Xd0tzZkZFUkNzVEZFUUsyVDdiY1BkaXBzTVl5V3NBRjk2QjFMTWFsNTVJWng3NWJGY015UmJrN1pHbUpwK2htNXNwVkk4NmVLSzA0MmgraEFEUyt1MTFEcFMvYlArNzl4elZRaERQRW1IcUdqUDRxWlRObnEyQ0Y2LzhnK1ZlWGc1YVV0ZHdaa3hncEx5elZEVTVSeHUzT1BadjRMY0pnVjVyYUNrdnl1LzczUnd1dlpTQlU3RTJoREZXaC9hUlJXamg0OVEyUmtKam4yNkFpK0EzZFhuWU43NVk2K1IxdUE2bDBEU0IxbmJ1Ny9SMjcrSlA3VTNOSDgzeUpBN051RG5XTG05M2N3S0tROGRQb2wxSklUaDVMcGI0SWc9PQ==')
            ->get();
        }catch (\Exception $e){
            return false;
        }
    }
}