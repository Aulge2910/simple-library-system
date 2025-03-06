<?php
class Publisher {	
   
	private $publisherTable = 'publisher';	
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }
	
	public function listPublisher(){		
		
		$sqlQuery = "SELECT publisher_id, publisher_name, publisher_status
			FROM ".$this->publisherTable." ";			
			
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' WHERE (publisher_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR publisher_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR publisher_status LIKE "%'.$_POST["search"]["value"].'%" ';						
		}
		
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY publisher_id DESC ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' .$_POST['length'];
		}	
		
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();	
		
		$stmtTotal = $this->conn->prepare($sqlQuery);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;
		
		$displayRecords = $result->num_rows;
		$records = array();	
		$count = 1;
		while ($publisher = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $count;
			$rows[] = ucfirst($publisher['publisher_name']);
			$rows[] = $publisher['publisher_status'];							
			$rows[] = '<button type="button" name="update" id="'.$publisher["publisher_id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Edit</span></button>';
			$rows[] = '<button type="button" name="delete" id="'.$publisher["publisher_id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete">Delete</span></button>';
			$records[] = $rows;
			$count++;
		}
		
		$output = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$displayRecords,
			"iTotalDisplayRecords"	=>  $allRecords,
			"data"	=> 	$records
		);
		
		echo json_encode($output);
	}	
	
	public function insert(){
		
		if($this->name && $_SESSION["user_id"]) {

			$stmt = $this->conn->prepare("
				INSERT INTO ".$this->publisherTable."(`publisher_name`, `publisher_status`)
				VALUES(?, ?)");
		
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->status = htmlspecialchars(strip_tags($this->status));
			
			$stmt->bind_param("ss", $this->name, $this->status);
			
			if($stmt->execute()){
				return true;
			}		
		}
	}
	
	public function update(){
		
		if($this->name && $_SESSION["user_id"]) {			
	
			$stmt = $this->conn->prepare("
				UPDATE ".$this->publisherTable." 
				SET publisher_name = ?, publisher_status = ?
				WHERE publisher_id = ?");
	 
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->status = htmlspecialchars(strip_tags($this->status));
			$this->publisherid = htmlspecialchars(strip_tags($this->publisherid));
			
			$stmt->bind_param("ssi", $this->name, $this->status, $this->publisherid);
			
			if($stmt->execute()){				
				return true;
			}			
		}	
	}	
	
	public function delete(){
		if($this->publisherid && $_SESSION["user_id"]) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->publisherTable." 
				WHERE publisher_id = ?");

			$this->publisherid = htmlspecialchars(strip_tags($this->publisherid));

			$stmt->bind_param("i", $this->publisherid);

			if($stmt->execute()){				
				return true;
			}
		}
	}
	
	public function getPublisherDetails(){
		if($this->publisherid && $_SESSION["user_id"]) {			
					
			$sqlQuery = "
				SELECT publisher_id, publisher_name, publisher_status
				FROM ".$this->publisherTable."			
				WHERE publisher_id = ? ";	
					
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->publisherid);	
			$stmt->execute();
			$result = $stmt->get_result();				
			$records = array();		
			while ($publisher = $result->fetch_assoc()) { 				
				$rows = array();	
				$rows['publisherid'] = $publisher['publisher_id'];				
				$rows['publisher_name'] = $publisher['publisher_name'];				
				$rows['publisher_status'] = $publisher['publisher_status'];				
				$records[] = $rows;
			}		
			$output = array(			
				"data"	=> 	$records
			);
			echo json_encode($output);
		}
	}	
	
	
}
?>