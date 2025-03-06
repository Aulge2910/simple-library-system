<?php
class Books {	
   
	private $bookTable = 'book';
	private $issuedBookTable = 'issued_book';
	private $categoryTable = 'category';
	private $authorTable = 'author';
	private $publisherTable = 'publisher';	
	private $rackTable = 'rack';
	private $userTable = 'user';
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }
	
	public function listBook(){		
		
		$sqlQuery = "SELECT book.book_id, book.picture, book.book_name, book.book_status, book.isbn, book.no_of_copy, book.updated_on, 
		author.author_name as author_name, category.category_name AS category_name, rack.rack_name As rack_name,
		 publisher.publisher_name AS publisher_name 

			FROM ".$this->bookTable." book		    
			LEFT JOIN ".$this->authorTable." author ON author.author_id = book.author_id
			LEFT JOIN ".$this->categoryTable." category ON category.category_id = book.category_id
			LEFT JOIN ".$this->rackTable." rack ON rack.rack_id = book.rack_id
			LEFT JOIN ".$this->publisherTable." publisher ON publisher.publisher_id = book.publisher_id ";			
			
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' WHERE (book.book_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR book.book_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR book.book_status LIKE "%'.$_POST["search"]["value"].'%" ';						
		}
		
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY book.book_id DESC ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . 100000000;
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
		while ($book = $result->fetch_assoc()) { 				
			$rows = array();	
			if(!$book['picture']) {
				$book['picture'] = 'default.jpg';
			}
			$rows[] = '<img src="images/'.$book['picture'].'" width="80" height="90">';
			$rows[] = ucfirst($book['book_name']);
			$rows[] = ucfirst($book['isbn']);
			$rows[] = ucfirst($book['author_name']);
			$rows[] = ucfirst($book['publisher_name']);
			$rows[] = ucfirst($book['category_name']);
			$rows[] = ucfirst($book['rack_name']);
			$rows[] = ucfirst($book['no_of_copy']);
			$rows[] = $book['book_status'];	
			$rows[] = $book['updated_on'];				
			$rows[] = '<button type="button" name="update" id="'.$book["book_id"].'" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit">Edit</span></button>';
			$rows[] = '<button type="button" name="delete" id="'.$book["book_id"].'" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete">Delete</span></button>';
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
				INSERT INTO ".$this->bookTable."(`book_name`, `book_status`, `isbn`, `no_of_copy`, `category_id`, `author_id`, `rack_id`, `publisher_id`)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
		
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->isbn = htmlspecialchars(strip_tags($this->isbn));
			$this->no_of_copy = htmlspecialchars(strip_tags($this->no_of_copy));
			$this->author = htmlspecialchars(strip_tags($this->author));
			$this->publisher = htmlspecialchars(strip_tags($this->publisher));
			$this->category = htmlspecialchars(strip_tags($this->category));
			$this->rack = htmlspecialchars(strip_tags($this->rack));
			$this->status = htmlspecialchars(strip_tags($this->status));			
			
			$stmt->bind_param("sssiiiii", $this->name, $this->status, $this->isbn, $this->no_of_copy, $this->category, $this->author, $this->rack, $this->publisher);
			
			if($stmt->execute()){
				return true;
			}		
		}
	}
	
	public function update(){
		
		if($this->name && $_SESSION["user_id"]) {			
	
			$stmt = $this->conn->prepare("
				UPDATE ".$this->bookTable." 
				SET book_name = ?, book_status = ?, isbn = ?, no_of_copy = ?, category_id = ?, author_id = ?, rack_id = ?, publisher_id = ?
				WHERE book_id = ?");
	 
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->isbn = htmlspecialchars(strip_tags($this->isbn));
			$this->no_of_copy = htmlspecialchars(strip_tags($this->no_of_copy));
			$this->author = htmlspecialchars(strip_tags($this->author));
			$this->publisher = htmlspecialchars(strip_tags($this->publisher));
			$this->category = htmlspecialchars(strip_tags($this->category));
			$this->rack = htmlspecialchars(strip_tags($this->rack));
			$this->status = htmlspecialchars(strip_tags($this->status));
			$this->bookid = htmlspecialchars(strip_tags($this->bookid));
			
			$stmt->bind_param("sssiiiiii", $this->name, $this->status, $this->isbn, $this->no_of_copy, $this->category, $this->author, $this->rack, $this->publisher, $this->bookid);
			
			if($stmt->execute()){				
				return true;
			}			
		}	
	}	
	
	public function delete(){
		if($this->bookid && $_SESSION["user_id"]) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->bookTable." 
				WHERE book_id = ?");

			$this->bookid = htmlspecialchars(strip_tags($this->bookid));

			$stmt->bind_param("i", $this->bookid);

			if($stmt->execute()){				
				return true;
			}
		}
	}
	
	public function getBookDetails(){
		if($this->bookid && $_SESSION["user_id"]) {

			$sqlQuery = "SELECT book.book_id, book.picture, book.book_name, book.book_status, book.isbn, book.no_of_copy, book.updated_on, author.author_id, category.category_id, rack.rack_id, publisher.publisher_id 
			FROM ".$this->bookTable." book		    
			LEFT JOIN ".$this->authorTable." author ON author.author_id = book.author_id
			LEFT JOIN ".$this->categoryTable." category ON category.category_id = book.category_id
			LEFT JOIN ".$this->rackTable." rack ON rack.rack_id = book.rack_id
			LEFT JOIN ".$this->publisherTable." publisher ON publisher.publisher_id = book.publisher_id 
			WHERE book_id = ? ";			
					
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->bookid);	
			$stmt->execute();	
			$result = $stmt->get_result();				
			$records = array();		
			while ($book = $result->fetch_assoc()) { 				
				$rows = array();	
				$rows['book_id'] = $book['book_id'];				
				$rows['book_name'] = $book['book_name'];				
				$rows['book_status'] = $book['book_status'];
				$rows['isbn'] = $book['isbn'];
				$rows['no_of_copy'] = $book['no_of_copy'];
				$rows['category_id'] = $book['category_id'];
				$rows['rack_id'] = $book['rack_id'];
				$rows['publisher_id'] = $book['publisher_id'];
				$rows['author_id'] = $book['author_id'];
				$records[] = $rows;
			}		
			$output = array(			
				"data"	=> 	$records
			);
			echo json_encode($output);
		}
	}
	
	function getAuthorList(){		
		$stmt = $this->conn->prepare("
		SELECT author_id, author_name 
		FROM ".$this->authorTable);				
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}

	function getCategoryList(){		
		$stmt = $this->conn->prepare("
		SELECT category_id, category_name 
		FROM ".$this->categoryTable);				
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}
	
	function getPublisherList(){		
		$stmt = $this->conn->prepare("
		SELECT publisher_id, publisher_name 
		FROM ".$this->publisherTable);				
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}
	
	function getRackList(){		
		$stmt = $this->conn->prepare("
		SELECT rack_id, rack_name 
		FROM ".$this->rackTable);				
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}
	
	function getBookList(){		
		$stmt = $this->conn->prepare("
		SELECT book.book_id, book.book_name, issued_book.issued_book_status
		FROM ".$this->bookTable." book
		LEFT JOIN ".$this->issuedBookTable." issued_book ON issued_book.book_id = book.book_id");				
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}
	
	function getTotalBooks(){		
		$stmt = $this->conn->prepare("
		SELECT *
		FROM ".$this->bookTable);				
		$stmt->execute();			
		$result = $stmt->get_result();
		return $result->num_rows;	
	}	
	
	
	function getTotalIssuedBooks(){		
		$stmt = $this->conn->prepare("
		SELECT * 
		FROM ".$this->issuedBookTable." 
		WHERE issued_book_status = 'Issued'");				
		$stmt->execute();			
		$result = $stmt->get_result();
		return $result->num_rows;	
	}
	
	
	function getTotalReturnedBooks(){		
		$stmt = $this->conn->prepare("
		SELECT * 
		FROM ".$this->issuedBookTable." 
		WHERE issued_book_status = 'Returned'");				
		$stmt->execute();			
		$result = $stmt->get_result();
		return $result->num_rows;	
	}
	
	
	
}
?>