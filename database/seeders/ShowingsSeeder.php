<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesPerson;
use App\Models\Property;
use App\Models\Customer;
use App\Models\PropertyShowing;

class ShowingsSeeder extends Seeder
{
    public function run()
    {
        $salesPersons = SalesPerson::all();
        $properties = Property::all();
        $customers = Customer::all();

        if ($salesPersons->isEmpty() || $properties->isEmpty() || $customers->isEmpty()) {
            return;
        }

        // Clean existing showings to start fresh
        PropertyShowing::query()->delete();

        $showings = [
            [
                'customer' => 'Arun Kumar',
                'property' => '3BHK Apartment in Andheri',
                'salesperson' => 'Kamlesh',
                'date' => '2026-06-01',
            ],
            [
                'customer' => 'Neha Gupta',
                'property' => '2BHK Villa in Whitefield',
                'salesperson' => 'Akshay',
                'date' => '2026-06-02',
            ],
            [
                'customer' => 'Rajesh Verma',
                'property' => 'Commercial Space in Connaught Place',
                'salesperson' => 'Rahul Sharma',
                'date' => '2026-06-03',
            ],
            [
                'customer' => 'Anjali Mehta',
                'property' => 'Independent House in Banjara Hills',
                'salesperson' => 'Priya Patel',
                'date' => '2026-06-04',
            ],
            [
                'customer' => 'Deepak Tiwari',
                'property' => 'Studio Apartment in Koregaon Park',
                'salesperson' => 'Amit Singh',
                'date' => '2026-06-05',
            ],
            [
                'customer' => 'Arun Kumar',
                'property' => 'Penthouse in Marine Drive',
                'salesperson' => 'Kamlesh',
                'date' => '2026-06-06',
            ],
            [
                'customer' => 'Neha Gupta',
                'property' => 'Plot in Electronic City',
                'salesperson' => 'Akshay',
                'date' => '2026-06-07',
            ],
            [
                'customer' => 'Rajesh Verma',
                'property' => 'Duplex in GK II',
                'salesperson' => 'Rahul Sharma',
                'date' => '2026-06-08',
            ],
            [
                'customer' => 'Anjali Mehta',
                'property' => '1BHK Flat in Salt Lake',
                'salesperson' => 'Priya Patel',
                'date' => '2026-06-09',
            ],
            [
                'customer' => 'Deepak Tiwari',
                'property' => 'Farmhouse in Alibaug',
                'salesperson' => 'Amit Singh',
                'date' => '2026-06-09',
            ],
        ];

        foreach ($showings as $s) {
            $cust = Customer::where('name', $s['customer'])->first();
            $prop = Property::where('title', $s['property'])->first();
            $sp = SalesPerson::where('name', $s['salesperson'])->first();

            if ($cust && $prop && $sp) {
                PropertyShowing::create([
                    'customer_id' => $cust->id,
                    'property_id' => $prop->id,
                    'sales_person_id' => $sp->id,
                    'show_date' => $s['date'],
                ]);
            }
        }
    }
}
