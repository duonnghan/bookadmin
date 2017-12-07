<?php

print_r($_POST);
print_r($_FILES);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
</head>
<body>
	<form id="data" method="post" enctype="multipart/form-data">
    <input type="text" name="name" value="Bob" />
    <input type="text" name="price" value="James" />
    <input type="text" name="author" value="Smith" />
    <input name="image" type="file" />
    <button>Submit</button>
</form>
</body>
</html>


<script type="text/javascript">
	$("form#data").submit(function(e) {
    e.preventDefault();    
    var formData = new FormData(this);

    $.ajax({
        url: "action4.php",
        type: 'POST',
        data: formData,
        success: function (data) {
            alert(data)
        },
        cache: false,
        contentType: false,
        processData: false
    });
});
</script>