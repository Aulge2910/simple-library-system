<?php
require_once __DIR__ . "/lib/DataSource.php";
$database = new DataSource();
$sql = "SELECT * FROM toy WHERE id=?";
$paramType = 'i';
$paramValue = array(
    $_GET["id"]
);
$result = $database->select($sql, $paramType, $paramValue);
?>
<td colspan=6 class="edit-form">
    <form name="frmToy" method="post" action="">
        <div class="row">
            <label style="padding-top: 20px;">Name: <span id="name-error-info"
                class="validation-message required"></span></label> <input
                type="text" name="name" id="edit-name"
                value="<?php echo $result[0]["name"]; ?>">
        </div>
        <div class="row">
            <label>Code: <span id="code-error-info" class="validation-message required"></span></label>
            <input type="text" name="code" id="edit-code"
                value="<?php echo $result[0]["code"]; ?>">
        </div>
        <div class="row">
            <label>Category: <span id="category-error-info"
                class="validation-message required"></span></label> <input
                type="text" name="category" id="edit-category"
                value="<?php echo $result[0]["category"]; ?>">
        </div>
        <div class="row">
            <label>Price: <span id="price-error-info"
                class="validation-message required"></span></label> <input
                type="text" name="price" id="edit-price"
                value="<?php echo $result[0]["price"]; ?>">
        </div>
        <div class="row">
            <label>Stock Count: <span id="stock-error-info"
                class="validation-message required"></span></label> <input
                type="text" name="stock_count" id="edit-stock"
                value="<?php echo $result[0]["stock_count"]; ?>">
        </div>
        <div class="row">
            <input type="button" name="submit" id="btnEditAction"
                value="Save"
                onClick="edit(this,<?php echo $result[0]["id"]; ?>);" />
            <div class="display-none" id="edit-loader">
                <img alt='Loader' src='spinner.svg' class='align-middle'>Processing...
            </div>
        </div>
    </form>
</td>