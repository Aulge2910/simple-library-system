<?php
require_once __DIR__ . "/lib/DataSource.php";
$database = new DataSource();
$sql = "UPDATE toy SET name=?, code=?, category=?, price=?, stock_count=? WHERE id=?";
$paramType = 'sssdii';
$paramValue = array(
    $_POST["name"],
    $_POST["code"],
    $_POST["category"],
    $_POST["price"],
    $_POST["stock_count"],
    $_GET["id"]
);
$updateId = $database->execute($sql, $paramType, $paramValue);
$sql = "SELECT * FROM toy WHERE id=?";
$paramType = 'i';
$paramValue = array(
    $_GET["id"]
);
$result = $database->select($sql, $paramType, $paramValue);
?>
<td><?php echo $result[0]["name"]; ?></td>
<td><?php echo $result[0]["code"]; ?></td>
<td><?php echo $result[0]["category"]; ?></td>
<td><?php echo $result[0]["price"]; ?></td>
<td><?php echo $result[0]["stock_count"]; ?></td>
<td class="action"><a class="mr-20 cursor-pointer"
	onClick="showEdit(this,<?php echo $_GET["id"]; ?>)">Edit</a> <a
	class="btnDeleteAction cursor-pointer"
	onClick="del(this,<?php echo $_GET["id"]; ?>)">Delete</a></td>