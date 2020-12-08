<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationRequest extends Model
{
	protected $table='registration_requests';
	protected $primaryKey='id';
	protected  $fillable = [
		'email',
		'business_name',
		'business_phone'
	];

	public function saveRequest($request){

			$request->validate([
				'name' => 'required',
				'email' => 'required|unique:registration_requests',
				'business_name' => 'required',
				'business_phone' => 'required|unique:registration_requests',
				'address' => 'required',
				'message' => 'required',
			]);
			$this->name = $request['name'];
			$this->business_name = $request['business_name'];
			$this->business_phone = $request['business_phone'];
			$this->email = $request['email'];
			$this->address = $request['address'];
			$this->message = $request['message'];
			if($this->save()) {
				return true;
			} else {
				return false;
			}
			
			//create associcate array for the input
			// $data[] = [
			// 	'email' => $request['email'],
			// 	'business_name' => $request['cname'],
			// 	'business_phone' => $request['mobile'],
			// 	"created_at" =>  \Carbon\Carbon::now(), # new \Datetime()
			// 	"updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
			// ];

		// DB::table('registration_requests')->insert($data);
	}
}
