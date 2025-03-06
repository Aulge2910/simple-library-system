<?php
require_once __DIR__ . "/lib/DataSource.php";
require_once __DIR__ . "/lib/pagination.class.php";
$database = new DataSource();

$perPage = new PerPage();

$queryCondition = "";
$paramType = "";
$paramValue = array();
if (!empty($_POST["name"])) {
	$queryCondition .= " WHERE book_name LIKE ?";
	$paramType .= "s";
	$paramValue[] = $_POST["name"];
}

if (!empty($_POST["code"])) {
	if (!empty($queryCondition)) {
		$queryCondition .= " AND ";
	} else {
		$queryCondition .= " WHERE ";
	}
	$queryCondition .= " book_category LIKE ?";
	$paramType .= "s";
	$paramValue[] = $_POST["code"];
}

$orderby = " ORDER BY book_id desc";
$sql = "SELECT * FROM books " . $queryCondition;
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

if (empty($_GET["rowcount"])) {
	$_GET["rowcount"] = $database->getRecordCount($sql, $paramType, $paramValue);
}
$perpageresult = $perPage->perpage($_GET["rowcount"], $paginationlink);
?> 


<form name="frmSearch" method="post" action="index.php">
	<div>
		<p>
			<input type="hidden" id="rowcount" name="rowcount" value="<?php echo $_GET["rowcount"]; ?>" />
		</p>
	</div>
	<div class="container search-bar">
        <div class="row border-1 search-bar__content" >
            <div class="col-sm col-md-3 col-lg-4" >
                <input class="w-100 h-100 flex-shrink-1 flex-fill search-input" id="name" name="name"type="search" placeholder="Search Name" aria-label="Search"
                value="<?php if (!empty($_POST["name"])) {} ?>" />
            
                
            </div>
            <div class="col-sm col-md-3 col-lg-4">
                <select class="form-select search-input" name="code " id="code" aria-label="Default select example"  >
                    <option selected>Category</option>
                    <option value="adventure">Adventure</option>
                    <option value="thrill">Thrill</option>
                    <option value="family">Family</option>
                </select>
            </div>

            <div class="col-sm col-md-3 col-lg-4">
            <button class="btn btn-outline-dark d-inline "name="go" class="btnSearch" value="Search" type="submit" 
            onclick="getresult('<?php echo $paginationlink . $page; ?>')">submit</button>
            <button class="btn btn-outline-dark d-inline " class="btnReset" value="Reset" type="reset" onclick="window.location='index.php'" >reset</button>
            </div>
        </div>
    </div>

	<div id="search_data_ajax"class="container">
        <div class="row search-box">
            <div class="col-12 search-result">
                <h4>Result for 'Search Result'</h4>
                <span class="fw-light">xxx Results on TodayDate</span>
            </div>
            <div class="search-filter col-sm-12 col-md-4 col-lg-3">
                 <div class="filter-box">
                    <div class="filter-header">
                        All Category
                    </div>
                    <div class="filter-content">
                        <div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check" autocomplete="off" value="thrill" name="category">
                            <label class="btn btn-outline-dark" for="btn-check">Thrill</label>
                            <span class="float-end">Num</span>
                        </div>
                        <div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check2" autocomplete="off" value="adventure"  name="category">
                            <label class="btn btn-outline-dark" for="btn-check2">Adventure</label>
                            <span class="float-end">54</span>
                        </div>
						<div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check3" autocomplete="off" value="family"  name="category">
                            <label class="btn btn-outline-dark" for="btn-check2">Family</label>
                            <span class="float-end">54</span>
                        </div>
						<div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check4" autocomplete="off"  value="children" name="category">
                            <label class="btn btn-outline-dark" for="btn-check2">Children</label>
                            <span class="float-end">54</span>
                        </div>
						<div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check5" autocomplete="off"  value="romance" name="category">
                            <label class="btn btn-outline-dark" for="btn-check2">Romance</label>
                            <span class="float-end">54</span>
                        </div>
						<div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check6" autocomplete="off"  value="fantasy" name="category">
                            <label class="btn btn-outline-dark" for="btn-check2">Fantasy</label>
                            <span class="float-end">54</span>
                        </div>
						<div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check6" autocomplete="off"  value="mistery" name="category">
                            <label class="btn btn-outline-dark" for="btn-check2">Mistery</label>
                            <span class="float-end">54</span>
                        </div>
						<div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check6" autocomplete="off"  value="horror" name="category">
                            <label class="btn btn-outline-dark" for="btn-check2">Horror</label>
                            <span class="float-end">54</span>
                        </div>
                    </div>
                 </div>

                 <div class="filter-box">
                    <div class="filter-header">
                        Publisher
                    </div>
                    <div class="filter-content">
                        <div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check3" autocomplete="off" value="mph_group" name="category">
                            <label class="btn btn-outline-dark" for="btn-check">MPH Group</label>
                            <span class="float-end">Num</span>
                        </div>
                        <div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check4" autocomplete="off" value="mardi" name="category">
                            <label class="btn btn-outline-dark" for="btn-check2">Mardi</label>
                            <span class="float-end">54</span>
                        </div>

						<div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check4" autocomplete="off" value="future_ace" name="category">
                            <label class="btn btn-outline-dark" for="btn-check2">Future Ace</label>
                            <span class="float-end">54</span>
                        </div>

						<div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check4" autocomplete="off" value="oyez" name="category">
                            <label class="btn btn-outline-dark" for="btn-check2">Oyez Book</label>
                            <span class="float-end">54</span>
                        </div>

						<div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check4" autocomplete="off" value="mardi" name="category">
                            <label class="btn btn-outline-dark" for="btn-check2">Mardi</label>
                            <span class="float-end">54</span>
                        </div>

						<div class="filter-item">
                            <input type="checkbox" class="btn-check" id="btn-check4" autocomplete="off" value="sird" name="category">
                            <label class="btn btn-outline-dark" for="btn-check2">SIRD</label>
                            <span class="float-end">54</span>
                        </div>
                    </div>
                 </div>
            </div>
            <div class="search-content col-sm-12 col-md-8 col-lg-9">
                <div class="row search-sorting">
                    <div class="col-lg-2 col-md-4 col-sm-3 text-center d-flex justify-content-center align-items-center p-2">
                       <span> Sort By</span>
                    </div>
                    <div class="col-lg-10 col-md-8 col-sm-9 p-2">
                    <select class="form-select w-55 sortBy" aria-label="Default select example"  >
                        <option selected>Category</option>
                        <option value="ascending">Ascending</option>
                        <option value="thrill">Descending</option>
                        <option value="family">Alphabetical</option>
                    </select>
                    </div>
                </div>
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
                            <p>
							<?php echo $result[$k]["book_name"]; ?>
                            </p>
                            <span><?php echo $result[$k]["book_category"]; ?></span>&nbsp;
							<span class="float-end"><?php echo $result[$k]["publisher"]; ?></span>
                            <p><?php echo $result[$k]["price"]; ?></p>
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