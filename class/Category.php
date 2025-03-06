<?php
class Category {	
   
	private $categoryTable = 'category';	
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }
	
	public function listCategory(){		
		
		$sqlQuery = "SELECT category_id,category_name, category_status
			FROM ".$this->categoryTable." ";			
			
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' WHERE (category_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR category_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR category_status LIKE "%'.$_POST["search"]["value"].'%" ';						
		}
		
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY category_id DESC ';
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
		while ($category = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $count;
			$rows[] = ucfirst($category['category_name']);
			$rows[] = $category['category_status'];							
			$rows[] = '<button type="button" name="update" id="'.$category["category_id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Edit</span></button>';
			$rows[] = '<button type="button" name="delete" id="'.$category["category_id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete">Delete</span></button>';
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
				INSERT INTO ".$this->categoryTable."(`category_name`, `category_status`)
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
				UPDATE ".$this->categoryTable." 
				SET category_name = ?, category_status = ?
				WHERE category_id = ?");
	 
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->status = htmlspecialchars(strip_tags($this->status));
			$this->categoryid = htmlspecialchars(strip_tags($this->categoryid));
			
			$stmt->bind_param("ssi", $this->name, $this->status, $this->categoryid);
			
			if($stmt->execute()){				
				return true;
			}			
		}	
	}	
	
	public function delete(){
		if($this->categoryid && $_SESSION["user_id"]) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->categoryTable." 
				WHERE category_id = ?");

			$this->categoryid = htmlspecialchars(strip_tags($this->categoryid));

			$stmt->bind_param("i", $this->categoryid);

			if($stmt->execute()){				
				return true;
			}
		}
	}
	
	public function getCategoryDetails(){
		if($this->categoryid && $_SESSION["user_id"]) {			
					
			$sqlQuery = "
				SELECT category_id, category_name, category_status
				FROM ".$this->categoryTable."			
				WHERE category_id = ? ";	
					
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->categoryid);	
			$stmt->execute();
			$result = $stmt->get_result();				
			$records = array();		
			while ($category = $result->fetch_assoc()) { 				
				$rows = array();	
				$rows['categoryid'] = $category['category_id'];				
				$rows['category_name'] = $category['category_name'];				
				$rows['category_status'] = $category['category_status'];				
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