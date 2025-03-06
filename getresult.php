<?php
require_once __DIR__ . "/lib/DataSource.php";
require_once __DIR__ . "/lib/pagination.class.php";
 
$database = new DataSource();

$perPage = new PerPage();

$queryCondition = "";
$paramType = "";
$paramValue = array();


if (!empty($_POST["name"])) {

    $search_name = $_POST['name'];
	$queryCondition .= " WHERE book_name LIKE ?";
	$paramType .= "s";
	$paramValue[] = "%".$_POST["name"]."%";
};

if (!empty($_POST["code"])) {

    $search_code = $_POST['code'];
	$queryCondition .= " WHERE book_id LIKE ?";
	$paramType .= "s";
	$paramValue[] = "%".$_POST["code"]."%";
};


 

$orderby = " ORDER BY book_id desc";

$my_search_count="count(*)";
$my_search_all="* ";

$my_search_select = "SELECT ";
$my_common_query = "
        FROM book
        INNER JOIN category ON book.category_id = category.category_id
        INNER JOIN publisher ON book.publisher_id = publisher.publisher_id ";

$sql = $my_search_select.$my_search_all. $my_common_query. $queryCondition;
        
 

$paginationlink = "getresult.php?page=";
$page = 1;
if (!empty($_GET["page"])) {
	$page = $_GET["page"];
}

$start = ($page - 1) * $perPage->perpage;
if ($start < 0)
	$start = 0;

$query = $sql . $orderby . " limit " . $start . "," . $perPage->perpage;
$result = $database->select($query, $paramType, $paramValue);

 
?>
 
 
<?php
if (empty($_GET["rowcount"])) {
	$_GET["rowcount"] = $database->getRecordCount($sql, $paramType, $paramValue);
}
$perpageresult = $perPage->perpage($_GET["rowcount"], $paginationlink);
?>
 
<form name="frmSearch" method="post" action="search.php">
	<div>
		<p>
			<input type="hidden" id="rowcount" name="rowcount" value="<?php echo $_GET["rowcount"]; ?>" />
		</p>
	</div>

	<div class="container search-bar">
        <div class="row border-1 search-bar__content" >
            <div class="col-sm col-md-4 col-lg-4 my-1" >
               
			 
					<input  class="w-100 h-100 flex-shrink-1 flex-fill search-input" type="search" 
					placeholder="Search Name" name="name" id="name" class="search-input" aria-label="Search"
					  />

       
	
            
                
            </div>
            <div class="col-sm col-md-4 col-lg-4 my-1">
				                		 
            <input  class="w-100 h-100 flex-shrink-1 flex-fill search-input" type="search" 
					placeholder="Search ID" name="code" id="code" class="search-input" aria-label="Search"
					  />
 

			
       
            </div>

            <div class="col-sm col-md-4 col-lg-4 my-1">
					
				<a role="button" type="submit" name="go"		
				onclick="getresult('<?php echo $paginationlink . $page; ?>')" 
				class="btnSearch btn btn-outline-dark d-inline w-lg-100 w-100" value="Search">Search</a>
				
				<a role="button" type="reset" class="btnReset btn btn-outline-dark d-inline w-lg-100 w-100" value="Reset" 
                onclick="window.location='search.php'"> Clear  </a>
            </div>
        </div>
    </div>

	<div id="search_data_ajax"class="container">
        <div class="row search-box">
            <div class="col-12 search-result">
                <h4>Result for Searching 
                     
                </h4>
           
            </div>
     
            <div class="search-content col-sm-12 col-md-12 col-lg-12">
    
	    <div class="row search-item-result">
				<?php
			if (!empty($result)) {
				foreach ($result as $k => $v) {
                 
			?>

		

                    <div class="search-item col-lg-4 col-md-6 col-sm-6">
                        <div class="search-item-cover">
                            <img src="./img/1.png">
                        </div>
                        <div class="search-item-detail">
                            <p class="text-uppercase">
							<?php echo $result[$k]["book_name"]; ?>
                            </p>
                            <span class="text-uppercase"><?php echo $result[$k]["publisher_name"]; ?></span>&nbsp;
							<span class="float-end text-uppercase"><?php echo $result[$k]["no_of_copy"]?></span>
                            <p><?php echo $result[$k]["isbn"]?>...</p>
                        </div>
                    </div>
            
 
				<?php   
				}
			}
?> </div>
            </div>     

         </div>

<?php		if (isset($perpageresult)) {	?>
				<div class="container">
					<div class="d-flex justify-content-center align-items-center">
					 	<span class=""><?php echo $perpageresult; ?> </span>
					</div>
				</div>
			<?php } ?>
 
    </div> 
</form>
  