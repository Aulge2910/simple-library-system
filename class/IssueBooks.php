<?php
class IssueBooks {	
   
    private $issuedBookTable = 'issued_book';
	private $bookTable = 'book';
	private $userTable = 'user';
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }
	
	public function listIssuedBook(){		
		
		$sqlQuery = "SELECT issued_book.issuebook_id, 
		issued_book.issue_date_time, 
		issued_book.expected_return_date, 
		issued_book.return_date_time, 
		issued_book.issued_book_status As status, 
		book.book_name,
		book.isbn,
		user.first_name, 
		user.last_name 
			FROM ".$this->issuedBookTable." issued_book		    
			LEFT JOIN ".$this->bookTable." book ON book.book_id = issued_book.book_id
			LEFT JOIN ".$this->userTable." user ON user.user_id = issued_book.user_id ";			
			
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' WHERE (issued_book.issuebook_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR issued_book.issue_date_time LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR issued_book.issued_book_status LIKE "%'.$_POST["search"]["value"].'%" ';						
		}
		
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY issued_book.issuebook_id DESC ';
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
		while ($issueBook = $result->fetch_assoc()) { 				
			$rows = array();
			$rows[] = $count;			
			$rows[] = ($issueBook['book_name']);
			$rows[] = ucfirst($issueBook['isbn']);
			$rows[] = ucfirst($issueBook['first_name'])." ".ucfirst($issueBook['last_name']);
			$rows[] = ucfirst($issueBook['issue_date_time']);
			$rows[] = ucfirst($issueBook['expected_return_date']);
			$rows[] = ucfirst($issueBook['return_date_time']);			
			$rows[] = $issueBook['status'];					
			$rows[] = '<button type="button" name="update" id="'.$issueBook["issuebook_id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Edit</span></button>';
			$rows[] = '<button type="button" name="delete" id="'.$issueBook["issuebook_id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete">Delete</span></button>';
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
		
		if($this->book && $_SESSION["user_id"]) {

			$stmt = $this->conn->prepare("
				INSERT INTO ".$this->issuedBookTable."(`book_id`, `user_id`, `expected_return_date`, `return_date_time`, `status`)
				VALUES(?, ?, ?, ?, ?)");
		
			$this->book = htmlspecialchars(strip_tags($this->book));
			$this->users = htmlspecialchars(strip_tags($this->users));
			$this->expected_return_date = htmlspecialchars(strip_tags($this->expected_return_date));
			$this->return_date = htmlspecialchars(strip_tags($this->return_date));
			$this->status = htmlspecialchars(strip_tags($this->status));			
			
			$stmt->bind_param("iisss", $this->book, $this->users, $this->expected_return_date, $this->return_date, $this->status);
			
			if($stmt->execute()){
				return true;
			}		
		}
	}
	
	public function update(){
		
		if($this->issuebookid && $this->book && $_SESSION["user_id"]) {			
	
			$stmt = $this->conn->prepare("
				UPDATE ".$this->issuedBookTable." 
				SET book_id = ?, user_id = ?, expected_return_date = ?, return_date_time = ?, status = ?
				WHERE issuebook_id = ?");
	 
			$this->book = htmlspecialchars(strip_tags($this->book));
			$this->users = htmlspecialchars(strip_tags($this->users));
			$this->expected_return_date = htmlspecialchars(strip_tags($this->expected_return_date));
			$this->return_date = htmlspecialchars(strip_tags($this->return_date));
			$this->status = htmlspecialchars(strip_tags($this->status));
			
			$stmt->bind_param("iisssi", $this->book, $this->users, $this->expected_return_date, $this->return_date, $this->status, $this->issuebookid);
			
			if($stmt->execute()){				
				return true;
			}			
		}	
	}	
	
	public function delete(){
		if($this->issuebookid && $_SESSION["user_id"]) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->issuedBookTable." 
				WHERE issuebook_id = ?");

			$this->issuebookid = htmlspecialchars(strip_tags($this->issuebookid));

			$stmt->bind_param("i", $this->issuebookid);

			if($stmt->execute()){				
				return true;
			}
		}
	}
	
	public function getIssueBookDetails(){
		if($this->issuebookid && $_SESSION["user_id"]) {

			$sqlQuery = "SELECT issued_book.issuebook_id, issued_book.issue_date_time, issued_book.expected_return_date, 
			issued_book.return_date_time, 
			issued_book.issued_book_status, 
			issued_book.book_id,
			 issued_book.user_id, 
			 book.book_name,
			 book.isbn,
			FROM ".$this->issuedBookTable." issued_book		    
			LEFT JOIN ".$this->bookTable." book ON book.book_id = issued_book.book_id
			LEFT JOIN ".$this->userTable." user ON user.user_id = issued_book.user_id
			WHERE issued_book.issuebook_id = ?";			
					
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->issuebookid);	
			$stmt->execute();
			$result = $stmt->get_result();				
			$records = array();		
			while ($issueBook = $result->fetch_assoc()) { 				
				$rows = array();	
	 

				$rows['issuebookid'] = $issueBook['issuebook_id'];		
				$rows['isbn'] = $issueBook['isbn'];				
				$rows['bookid'] = $issueBook['book_id'];	
				
				$rows['status'] = $issueBook['status'];
				$rows['userid'] = $issueBook['user_id'];
				$rows['expected_return_date'] = date ('Y-m-d\TH:i:s', strtotime($issueBook['expected_return_date']));
				$rows['return_date_time'] = date ('Y-m-d\TH:i:s', strtotime($issueBook['return_date_time']));				
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