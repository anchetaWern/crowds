<?php

use Illuminate\Database\Seeder;
use App\ServiceType;

class ServiceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$service_types = [
    		[
    			'name' => 'Errand',
    			'bid_limit' => 5,
    			'description' => 'eg. Buying essential goods, transfer money, etc.'
    		],
    		[
    			'name' => 'Household services',
    			'bid_limit' => 5,
    			'description' => 'eg. Carpentry, plumbing, etc.'
    		],
    		[
    			'name' => 'Home health care',
    			'bid_limit' => 5,
    			'description' => 'eg. Nursing, physical therapy, companionship, etc.'
    		],
    		[
    			'name' => 'Transportation',
    			'bid_limit' => 5,
    			'description' => 'Ask someone with a private vehicle to transport you from one place to another'
    		],
    		[
    			'name' => 'Accommodation',
    			'bid_limit' => 5,
    			'description' => 'Ask for accommodation.'
    		],
    		[
    			'name' => 'Personal grooming',
    			'bid_limit' => 5,
    			'description' => 'eg. Haircut, manicure, etc.'
    		],
    		[
    			'name' => 'Donation and relief goods',
    			'bid_limit' => 0, // no limit on how many people can bid
    			'description' => 'Ask for donations or relief goods for you or on behalf of someone else.'
    		],
    		[
    			'name' => 'Others',
    			'bid_limit' => 0,
    			'description' => 'Other services not classified above.'
    		]
    	];

    	foreach ($service_types as $service) {
    		factory(ServiceType::class)->create([
    			'name' => $service['name'],
    			'bid_limit' => $service['bid_limit'],
    			'description' => $service['description']
    		]);
    	}
    }
}
