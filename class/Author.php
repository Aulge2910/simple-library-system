<?php
class Author {	
   
	private $authorTable = 'author';	
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }
	
	public function listAuthor(){		
		
		$sqlQuery = "SELECT author_id, author_name, author_status
			FROM ".$this->authorTable." ";			
			
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' WHERE (author_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR author_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR author_status LIKE "%'.$_POST["search"]["value"].'%" ';						
		}
		
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY author_id DESC ';
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
		while ($author = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $count;
			$rows[] = ucfirst($author['author_name']);
			$rows[] = $author['author_status'];							
			$rows[] = '<button type="button" name="update" id="'.$author["author_id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Edit</span></button>';
			$rows[] = '<button type="button" name="delete" id="'.$author["author_id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete">Delete</span></button>';
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
				INSERT INTO ".$this->authorTable."(`author_name`, `author_status`)
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
				UPDATE ".$this->authorTable." 
				SET author_name = ?, author_status = ?
				WHERE author_id = ?");
	 
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->status = htmlspecialchars(strip_tags($this->status));
			$this->authorid = htmlspecialchars(strip_tags($this->authorid));
			
			$stmt->bind_param("ssi", $this->name, $this->status, $this->authorid);
			
			if($stmt->execute()){				
				return true;
			}			
		}	
	}	
	
	public function delete(){
		if($this->authorid && $_SESSION["user_id"]) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->authorTable." 
				WHERE author_id = ?");

			$this->authorid = htmlspecialchars(strip_tags($this->authorid));

			$stmt->bind_param("i", $this->authorid);

			if($stmt->execute()){				
				return true;
			}
		}
	}
	
	public function getAuthorDetails(){
		if($this->authorid && $_SESSION["user_id"]) {			
					
			$sqlQuery = "
				SELECT author_id, author_name, author_status
				FROM ".$this->authorTable."			
				WHERE author_id = ? ";	
					
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->authorid);	
			$stmt->execute();
			$result = $stmt->get_result();				
			$records = array();		
			while ($author = $result->fetch_assoc()) { 				
				$rows = array();	
				$rows['authorid'] = $author['author_id'];				
				$rows['author_name'] = $author['author_name'];				
				$rows['author_status'] = $author['author_status'];				
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