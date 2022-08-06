<?php 

namespace App\Models;

use App\Lib\DatabaseConnection;

class BaseModel {
	
	protected $connection;
	
	public function __construct() {
		if (!$this->connection) {
			$this->connection = new DatabaseConnection();
		}		
	}

}