<?php

class User
{
	private $conn;
	private $table_name = "users";

	public $id;
	public $name;
	public $secondname;
	public $login;
	public $password;
	public $gender;
	public $location;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	function create()
	{
		$query = "INSERT INTO " . $this->table_name . " 
		SET
			password = :password,
			login = :login,
			name = :name,
			secondName = :secondname,
			gender = :gender,
			location = :location";

		$stmt = $this->conn->prepare($query);

		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->secondname = htmlspecialchars(strip_tags($this->secondname));
		$this->login = htmlspecialchars(strip_tags($this->login));
		$this->password = htmlspecialchars(strip_tags($this->password));
		$this->gender = htmlspecialchars(strip_tags($this->gender));
		$this->location = htmlspecialchars(strip_tags($this->location));

		$stmt->bindParam(':login', $this->login);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':secondname', $this->secondname);
		$stmt->bindParam(':gender', $this->gender);
		$stmt->bindParam(':location', $this->location);

		$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
		$stmt->bindParam(':password', $password_hash);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	function loginExists()
	{
		$query = "SELECT id, name, secondName, password
            FROM " . $this->table_name . "
            WHERE login = ?
            LIMIT 0,1";

		$stmt = $this->conn->prepare($query);
		$this->login = htmlspecialchars(strip_tags($this->login));

		$stmt->bindParam(1, $this->login);

		$stmt->execute();

		$num = $stmt->rowCount();

		if ($num > 0) {

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$this->id = $row['id'];
			$this->name = $row['name'];
			$this->secondname = $row['secondName'];
			$this->password = $row['password'];

			return true;
		}

		return false;
	}

	public function update()
	{

		$password_set = !empty($this->password) ? ", password = :password" : "";

		// если не введен пароль - не обновлять пароль
		$query = "UPDATE " . $this->table_name . "
		SET
                name = :name,
                secondName = :secondname,
                gender = :gender,
                location = :location,
                login = :login
                {$password_set} WHERE id = :id";

		$stmt = $this->conn->prepare($query);

		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->secondname = htmlspecialchars(strip_tags($this->secondname));
		$this->login = htmlspecialchars(strip_tags($this->login));
		$this->login = htmlspecialchars(strip_tags($this->gender));
		$this->login = htmlspecialchars(strip_tags($this->location));

		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':secondname', $this->secondname);
		$stmt->bindParam(':login', $this->login);
		$stmt->bindParam(':gender', $this->gender);
		$stmt->bindParam(':location', $this->location);

		if (!empty($this->password)) {
			$this->password = htmlspecialchars(strip_tags($this->password));
			$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
			$stmt->bindParam(':password', $password_hash);
		}

		$stmt->bindParam(':id', $this->id);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}
}