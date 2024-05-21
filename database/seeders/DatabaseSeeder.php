<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@argon.com',
            'password' => bcrypt('secret')
        ]);

        $suppliers = [
            [
                'name' => 'MZO Trading',
                'email' => 'mzotrading@gmail.com',
                'pinned' => 'yes',
                'address_id' => '1',
            ],
            [
                'name' => 'Yoon Fatt Trading',
                'email' => 'yoonfattTrade@gmail.com',
                'pinned' => 'yes',
                'address_id' => '2',
            ],
            [
                'name' => 'Benta Jaya Trading',
                'email' => 'BentaJaya@gmail.com',
                'pinned' => 'no',
                'address_id' => '3',
            ],
            [
                'name' => 'Fish Net Trading',
                'email' => 'fishnet@gmail.com',
                'pinned' => 'no',
                'address_id' => '4',
            ],

        ];

        $customers = [
            [
                'name' => 'Chua Kian Pheng',
                'email' => 'chuakianpheng@gmail.com',
                'pinned' => 'yes',
                'address_id' => '5',
            ],
            [
                'name' => 'Lew Zhi Shin',
                'email' => 'lewzhishin@gmail.com',
                'pinned' => 'yes',
                'address_id' => '6',
            ],
            [
                'name' => 'Chong Xue Liang',
                'email' => 'chongxueliang@gmail.com',
                'pinned' => 'yes',
                'address_id' => '7',
            ],
            [
                'name' => 'Chong Jin Wen',
                'email' => 'chongjinwen@gmail.com',
                'pinned' => 'yes',
                'address_id' => '8',
            ],
        ];

        $contacts = [
            [
                'person_id' => '1',
                'contactnumber' => '0123456787',
                'type' => 'supplier',
            ],
            [
                'person_id' => '2',
                'contactnumber' => '0123456782',
                'type' => 'supplier',
            ],
            [
                'person_id' => '3',
                'contactnumber' => '0123466787',
                'type' => 'supplier',
            ],
            [
                'person_id' => '4',
                'contactnumber' => '0123454587',
                'type' => 'supplier',
            ],
            [
                'person_id' => '1',
                'contactnumber' => '0154456787',
                'type' => 'customer',
            ],
            [
                'person_id' => '2',
                'contactnumber' => '0163456787',
                'type' => 'customer',
            ],
            [
                'person_id' => '3',
                'contactnumber' => '0123456787',
                'type' => 'customer',
            ],
            [
                'person_id' => '4',
                'contactnumber' => '0123456787',
                'type' => 'customer',
            ],
        ];

        $addresses = [
            [
                'location' => 'kg keledek',
                'street' => 'Kuala Lipis',
                'code' => '27200',
                'state' => 'Pahang',
            ],
            [
                'location' => 'Kawasan Perindustrian Mara',
                'street' => 'Kota Bharu',
                'code' => '	16100',
                'state' => 'Kelantan',
            ],
            [
                'location' => '63, Jalan Haji Abdul Aziz,',
                'street' => 'Kuantan',
                'code' => '	25000',
                'state' => 'Pahang',
            ],
            [
                'location' => 'U0017, BA, Global Hotel, Jalan Okk Awang Besar,',
                'street' => 'Labuan',
                'code' => '	87000',
                'state' => 'Sabah',
            ],
        ];

        $items = [
            [
                'name' => 'Stainless Steel Hammer',
                'price1' => '25.00',
                'price2' => '23.00',
                'price3' => '20.00',
                'pic' => 'public/images/hammer.jpg',
                'description' => 'Stainless Steel Hammer 12 inch',
                'quantity' => '100',
                'minlevel' => '10',
                'unit' => 'pcs',
            ],
        ];

        foreach ($items as $item) {
            DB::table('items')->insert($item);
        }

        foreach ($suppliers as $supplier) {
            DB::table('suppliers')->insert($supplier);
        }
        
        foreach ($addresses as $address) {
            DB::table('addresses')->insert($address);
        }
        
        foreach ($addresses as $address) {
            DB::table('addresses')->insert($address);
        }
        
        foreach ($addresses as $address) {
            DB::table('addresses')->insert($address);
        }
        
        foreach ($customers as $customer) {
            DB::table('customers')->insert($customer);
        }
        
        foreach ($contacts as $contact) {
            DB::table('contacts')->insert($contact);
        }
    }
}
