<?php namespace App\Models\Traits;

use App\Models\_partials\Address;

trait AddressTrait
{
	public function assignAddress($data)
	  {
	    $street = $data['street'];
	    $house = $data['house'];
	    $corpus = $data['corpus'];

	    if(!$address = Address::whereStreet($street)->whereHouse($house)->whereCorpus($corpus)->first())
	      {
	        $address = $this->createAddress($street,$house,$corpus);
	      }
  			$address->increment('user_count');

	    return $this->addresses()->attach($address);
	  }
	  


	public function createAddress($street,$house,$corpus = null)
	  {
	      $address = Address::create([
	        'street' => $street,
	        'house'  => $house,
	        'corpus' => $corpus,
	        ]);

	      return $address;
	  }
}