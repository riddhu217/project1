<?php

//Api.php

class API
{
	private $connect = '';

	function __construct()
	{
		$this->database_connection();
	}

	function database_connection()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");
	}

	function fetch_all()
	{
		$query = "SELECT * FROM tbl_sample ORDER BY id";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}

	function insert()
	{
		if(isset($_POST["userid"]))
		{
			$form_data = array(
				':userid'		=>	$_POST["userid"],
				':title'		=>	$_POST["title"],
				':body'		=>	$_POST["body"]
			);
			$query = "
			INSERT INTO tbl_sample 
			(userid,title,body) VALUES 
			(:userid,:title,:body)
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}

	function fetch_single($id)
	{
		$query = "SELECT * FROM tbl_sample WHERE id='".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			foreach($statement->fetchAll() as $row)
			{
				$data['userid'] = $row['userid'];
				$data['title'] = $row['title'];
				$data['body'] = $row['body'];
			}
			return $data;
		}
	}

	function update()
	{
		if(isset($_POST["userid"]))
		{
			$form_data = array(
				':userid'	=>	$_POST['userid'],
				':title'	=>	$_POST['title'],
				':body'		=>	$_POST['body'],
				':id'		=>	$_POST['id']
			);
			$query = "
			UPDATE tbl_sample 
			SET userid = :userid, title = :title , body = :body
			WHERE id = :id
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
	function delete($id)
	{
		$query = "DELETE FROM tbl_sample WHERE id = '".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			$data[] = array(
				'success'	=>	'1'
			);
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
}

?>