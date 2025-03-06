<?php
require_once __DIR__ . "/lib/DataSource.php";
require_once __DIR__ . "/lib/pagination.class.php";
$database = new DataSource();

$perPage = new PerPage();

$queryCondition = "";
$paramType = "";
$paramValue = array();
if (!empty($_POST["name"])) {
	$queryCondition .= " WHERE name LIKE ?";
	$paramType .= "s";
	$paramValue[] = $_POST["name"];
}

if (!empty($_POST["code"])) {
	if (!empty($queryCondition)) {
		$queryCondition .= " AND ";
	} else {
		$queryCondition .= " WHERE ";
	}
	$queryCondition .= " code LIKE ?";
	$paramType .= "s";
	$paramValue[] = $_POST["code"];
}

$orderby = " ORDER BY book_id desc";
$sql = "SELECT * FROM books " . $queryCondition;
$paginationlink = "dgetresult.php?page=";
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
<style>
	button,
	input[type=button] {
		width: 140px;
		font-size: 14px;
		padding: 8px 0px;
		font-size: 14px;
		cursor: pointer;
		border-radius: 25px;
		color: #000000;
	}

	.btnSearch {
		background-color: #ffc72c;
		border-color: #ffd98e #ffbe3d #de9300;
	}

	.btnReset {
		border: 2px solid #d2d6dd;
	}

	button,
	input[type=button].perpage-link {
		width: auto;
		font-size: 14px;
		padding: 5px 10px;
		border: 2px solid #d2d6dd;
		border-radius: 4px;
		margin: 0px 5px;
		background-color: #fff;
		cursor: pointer;
	}

	.current-page {
		width: auto;
		font-size: 14px;
		padding: 5px 10px;
		border: 2px solid #d2d6dd;
		border-radius: 4px;
		margin: 0px 5px;
		background-color: #efefef;
		cursor: pointer;
	}

	.search-input {
		margin-right: 5px;
	}
</style>
<form name="frmSearch" method="post" action="dindex.php">
	<div>
		<p>
			<input type="hidden" id="rowcount" name="rowcount" value="<?php echo $_GET["rowcount"]; ?>" />
			
			<input type="text" placeholder="Name" name="name" id="name" class="search-input" 
			value="<?php if (!empty($_POST["name"])) {
																																					echo $_POST["name"];
	} ?>" />
	
	<input type="text" placeholder="Code" name="code" id="code" class="search-input" 
	value="<?php if (!empty($_POST["code"])) {
	echo $_POST["code"]; } ?>" />
	
	<input type="button" name="go" class="btnSearch" value="Search" onclick="getresult('<?php echo $paginationlink . $page; ?>')"> 
	
	<input type="button" class="btnReset" value="Reset" onclick="window.location='index.php'"> <span class="display-none"><img alt='Loader' src='spinner.svg' id="loader"></span>
		</p>
	</div>
	<div>
		<a id="btnAddAction" class="font-bold float-right cursor-pointer" onClick="$('#add-form').show();">Add New</a>
	</div>
	<table class="stripped">
		<thead>
			<tr>
				<th><strong>Name</strong></th>
				<th><strong>Code</strong></th>
				<th><strong>Category</strong></th>
				<th><strong>Price</strong></th>
				<th><strong>Stock Count</strong></th>
				<th><strong>Action</strong></th>

			</tr>
		</thead>
		<tbody>
			<?php
			if (!empty($result)) {
				foreach ($result as $k => $v) {
			?>
					<tr id="toy-<?php echo $result[$k]["id"]; ?>">
						<td><?php echo $result[$k]["name"]; ?></td>
						<td><?php echo $result[$k]["code"]; ?></td>
						<td><?php echo $result[$k]["category"]; ?></td>
						<td><?php echo $result[$k]["price"]; ?></td>
						<td><?php echo $result[$k]["stock_count"]; ?></td>
						<td><a class="mr-20 cursor-pointer" onClick="showEdit(this,<?php echo $result[$k]["id"]; ?>)">Edit</a>
							<a class="cursor-pointer" onClick="del(this,<?php echo $result[$k]["id"]; ?>)">Delete</a> <span class="display-none" id="action-loader"> <img alt='Loader' src='spinner.svg' class='align-middle'>
							</span>
						</td>
					</tr>
				<?php
				}
			}
			if (isset($perpageresult)) {
				?>
				<tr>
					<td colspan="6" align=right> <?php echo $perpageresult; ?></td>
				</tr>
			<?php } ?>



		<tbody>

	</table>
</form>