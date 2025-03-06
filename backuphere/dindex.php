<html>
<head>
<title>PHP CRUD with Search and Pagination</title>
<meta name="viewport" content="width=device-width , initial-scale=1.0">
<link href="assets/css/style.css" rel="stylesheet" type="text/css">
<link href="assets/css/form.css" rel="stylesheet" type="text/css">
<link href="assets/css/table.css" rel="stylesheet" type="text/css">
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
    crossorigin="anonymous"></script>
<script type="text/javascript" src="assets/js/crud.js"></script>
</head>
<body>
    <div class="phppot-container">
        <h2>PHP CRUD with Search and Pagination</h2>
        <div id="toys-grid">
            <input type="hidden" name="rowcount" id="rowcount" />
        </div>
        <div id="add-form" class="phppot-container">
            <form name="frmToy" method="post" action="" id="frmToy">
                <div class="row">
                    <label>Name: <span id="name-info"
                        class="validation-message req-field"></span></label> <input
                        type="text" name="name" id="add-name" class="">
                </div>
                <div class="row">
                    <label>Code: <span id="code-info"
                        class="validation-message req-field"></span></label> <input
                        type="text" name="code" id="add-code" class="">
                </div>
                <div class="row">
                    <label>Category: <span id="category-info"
                        class="validation-message req-field"></span></label><input
                        type="text" name="category" id="category"
                        class="">
                </div>
                <div class="row">
                    <label>Price: <span id="price-info"
                        class="validation-message req-field"></span></label> <input
                        type="text" name="price" id="price" class="">
                </div>
                <div class="row">
                    <label>Stock Count: <span id="stock_count-info"
                        class="validation-message req-field"></span></label><input
                        type="text" name="stock_count" id="stock_count"
                        class="">
                </div>
                <div class="row">
                    <input type="button" name="submit" id="btnAddAction"
                        value="Add" onClick="add();" />
                    <div class="display-none" id="add-loader">
                        <img alt='Loader' src='spinner.svg'
                            class='align-middle'>Processing...
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>