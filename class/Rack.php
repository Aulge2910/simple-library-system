<?php
class Rack {	
   
	private $rackTable = 'rack';	
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }
	
	public function listRack(){		
		
		$sqlQuery = "SELECT rack_id, rack_name, rack_status
			FROM ".$this->rackTable." ";			
			
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' WHERE (rack_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR rack_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR rack_status LIKE "%'.$_POST["search"]["value"].'%" ';						
		}
		
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY rack_id DESC ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
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
		while ($rack = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $count;
			$rows[] = ucfirst($rack['rack_name']);
			$rows[] = $rack['rack_status'];							
			$rows[] = '<button type="button" name="update" id="'.$rack["rack_id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Edit</span></button>';
			$rows[] = '<button type="button" name="delete" id="'.$rack["rack_id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete">Delete</span></button>';
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
				INSERT INTO ".$this->rackTable."(`rack_name`, `rack_status`)
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
				UPDATE ".$this->rackTable." 
				SET rack_name = ?, rack_status = ?
				WHERE rack_id = ?");
	 
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->status = htmlspecialchars(strip_tags($this->status));
			$this->rackid = htmlspecialchars(strip_tags($this->rackid));
			
			$stmt->bind_param("ssi", $this->name, $this->status, $this->rackid);
			
			if($stmt->execute()){				
				return true;
			}			
		}	
	}	
	
	public function delete(){
		if($this->rackid && $_SESSION["user_id"]) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->rackTable." 
				WHERE rack_id = ?");

			$this->rackid = htmlspecialchars(strip_tags($this->rackid));

			$stmt->bind_param("i", $this->rackid);

			if($stmt->execute()){				
				return true;
			}
		}
	}
	
	public function getRackDetails(){
		if($this->rackid && $_SESSION["user_id"]) {			
					
			$sqlQuery = "
				SELECT rack_id, rack_name, rack_status
				FROM ".$this->rackTable."			
				WHERE rack_id = ? ";	
					
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->rackid);	
			$stmt->execute();
			$result = $stmt->get_result();				
			$records = array();		
			while ($rack = $result->fetch_assoc()) { 				
				$rows = array();	
				$rows['rackid'] = $rack['rack_id'];				
				$rows['rack_name'] = $rack['rack_name'];				
				$rows['rack_status'] = $rack['rack_status'];				
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