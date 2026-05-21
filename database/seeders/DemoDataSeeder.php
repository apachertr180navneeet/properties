<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesPerson;
use App\Models\Property;
use App\Models\Customer;
use App\Models\AreaMaster;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        $persons = [];
        $names = [
            ['name' => 'Kamlesh', 'email' => 'kamlesh@example.com', 'phone' => '1234567890', 'city' => 'Jodhpur', 'status' => 'active'],
            ['name' => 'Akshay', 'email' => 'akshay@example.com', 'phone' => '1234567890', 'city' => 'Barmer', 'status' => 'active'],
            ['name' => 'Rahul Sharma', 'email' => 'rahul@example.com', 'phone' => '9876543210', 'city' => 'Jodhpur', 'status' => 'active'],
            ['name' => 'Priya Patel', 'email' => 'priya@example.com', 'phone' => '9876543211', 'city' => 'Mumbai', 'status' => 'active'],
            ['name' => 'Amit Singh', 'email' => 'amit@example.com', 'phone' => '9876543212', 'city' => 'Delhi', 'status' => 'inactive'],
        ];

        foreach ($names as $data) {
            $persons[] = SalesPerson::updateOrCreate(['email' => $data['email']], $data);
        }

        $propertyData = [
            ['title' => '3BHK Apartment in Andheri', 'price' => 8500000, 'status' => 'available', 'location' => 'Andheri West, Mumbai'],
            ['title' => '2BHK Villa in Whitefield', 'price' => 6500000, 'status' => 'available', 'location' => 'Whitefield, Bangalore'],
            ['title' => 'Commercial Space in Connaught Place', 'price' => 25000000, 'status' => 'sold', 'location' => 'Connaught Place, Delhi'],
            ['title' => 'Independent House in Banjara Hills', 'price' => 18000000, 'status' => 'available', 'location' => 'Banjara Hills, Hyderabad'],
            ['title' => 'Studio Apartment in Koregaon Park', 'price' => 4500000, 'status' => 'pending', 'location' => 'Koregaon Park, Pune'],
            ['title' => 'Penthouse in Marine Drive', 'price' => 35000000, 'status' => 'available', 'location' => 'Marine Drive, Mumbai'],
            ['title' => 'Plot in Electronic City', 'price' => 3200000, 'status' => 'available', 'location' => 'Electronic City, Bangalore'],
            ['title' => 'Duplex in GK II', 'price' => 22000000, 'status' => 'sold', 'location' => 'Greater Kailash II, Delhi'],
            ['title' => '1BHK Flat in Salt Lake', 'price' => 3800000, 'status' => 'available', 'location' => 'Salt Lake, Kolkata'],
            ['title' => 'Farmhouse in Alibaug', 'price' => 15000000, 'status' => 'pending', 'location' => 'Alibaug, Maharashtra'],
        ];

        foreach ($propertyData as $i => $data) {
            Property::firstOrCreate(
                ['title' => $data['title'], 'sales_person_id' => $persons[$i % count($persons)]->id],
                array_merge($data, ['sales_person_id' => $persons[$i % count($persons)]->id])
            );
        }

        $customerData = [
            ['name' => 'Arun Kumar', 'email' => 'arun@email.com', 'phone' => '9988776651'],
            ['name' => 'Neha Gupta', 'email' => 'neha@email.com', 'phone' => '9988776652'],
            ['name' => 'Rajesh Verma', 'email' => 'rajesh@email.com', 'phone' => '9988776653'],
            ['name' => 'Anjali Mehta', 'email' => 'anjali@email.com', 'phone' => '9988776654'],
            ['name' => 'Deepak Tiwari', 'email' => 'deepak@email.com', 'phone' => '9988776655'],
            ['name' => 'Pooja Desai', 'email' => 'pooja@email.com', 'phone' => '9988776656'],
            ['name' => 'Suresh Nair', 'email' => 'suresh@email.com', 'phone' => '9988776657'],
            ['name' => 'Kavita Jain', 'email' => 'kavita@email.com', 'phone' => '9988776658'],
            ['name' => 'Manoj Pandey', 'email' => 'manoj@email.com', 'phone' => '9988776659'],
            ['name' => 'Ritu Agarwal', 'email' => 'ritu@email.com', 'phone' => '9988776660'],
        ];

        foreach ($customerData as $i => $data) {
            Customer::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, ['sales_person_id' => $persons[$i % count($persons)]->id])
            );
        }

        $areaNames = ['Andheri West', 'Banjara Hills', 'Connaught Place', 'Whitefield', 'Marine Drive', 'Koregaon Park', 'Greater Kailash', 'Salt Lake', 'Electronic City', 'Alibaug'];

        foreach ($areaNames as $name) {
            AreaMaster::firstOrCreate(['area_name' => $name]);
        }
    }
}
