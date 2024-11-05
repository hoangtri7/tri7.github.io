<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Đăng nhập</title>
<link rel="stylesheet" href="CSS.css">
</head>

<body>
	<div class="container">
	<header><h2 class="head">Thêm khách hàng🧑🚢</h2></header>
	<form action="Đăngký.php" method="POST" enctype="multipart/form-data" >
	  <input type="makh" name="makh" id="makh" placeholder="makh">  
      <input type="tenkh" name="tenkh" id="tenkh" placeholder="tenkh" required>
      <input type="dienthoai" name="dienthoai" id="dienthoai" placeholder="dienthoai">
      <input type="file" name="hinhanh" id="hinhanh" placeholder="hinhanh">


<br>
	  <button class="btn" name="submit" type="submit">Thêm khách hàng mới</button><br>
	</form>
	</div>
</body>
</html>
<?php
if(isset($_POST['makh'])) {
	$con = mysqli_connect("localhost", "root", "", "qlvetau");
	if(!$con) {
		die("Connection failed due to" . mysqli_connect_error());
	}
	$makh = $_POST['makh'];
	$tenkh = $_POST['tenkh'];
	$dienthoai = $_POST['dienthoai'];
	if(isset($_FILES['hinhanh']))
	{
		$target_dir = "uploads";
		if (!is_dir($target_dir))
		{
			mkdir($target_dir, 0777, true);
		}
		$target_file = $target_dir . basename($_FILES["hinhanh"]["name"]);
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$check = getimagesize($_FILES["hinhanh"]["tmp_name"]);
		if($check !== false) {
			if ($_FILES["hinhanh"]["size"]> 500000)
			{
				echo "Kích thước hình quá lớn.";
				exit();
			}
			$allowed_file_types = ['jpg','jpeg','png','gif'];
			if(!in_array($imageFileType, $allowed_file_types))
			{
				echo"chỉ load được file có phần mở rộng là JPG, JPEG, PNG & GIF.";
				exit();
			}
			if (move_uploaded_file($_FILES["hinhanh"]["tmp_name"],$target_file))
			{
				$hinhanh = $target_file;
			}
			else
			{
				echo "Lỗi";
				exit();
			}
		}
		else
		{
			echo "Không phải là file hình ảnh.";
			exit();
		}
	}
	else
	{
		echo "Không có file hình ảnh được upload.";
		exit();
	}
	$sql="INSERT INTO `khachhang` (`makh`,`tenkh`, `dienthoai`, `hinhanh`)
	       VALUES ('$makh','$tenkh','$dienthoai','$hinhanh');";
	
	if($con->query($sql) === TRUE) {
		echo "khach hang moi da duoc them vao coso du lieu";
	}
	else{
		echo "ERROR: " . $sql . "<br>" . $con->error;
	}
	$con->close();
}
?>
