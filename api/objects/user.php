<?php

// объект 'user'
class User
{

	// подключение к БД таблице "users"
	private $conn;
	private $table_name = "users";

	// свойства объекта
	public $id;
	public $name;
	public $secondname;
	public $login;
	public $password;
	public $gender;
	public $location;

	// конструктор класса User
	public function __construct($db)
	{
		$this->conn = $db;
	}

	// Создание нового пользователя
	function create()
	{

		// Вставляем запрос
		$query = "INSERT INTO " . $this->table_name ." 
		SET
			password = :password,
			login = :login,
			name = :name,
			secondName = :secondname,
			gender = :gender,
			location = :location";

		// подготовка запроса
		$stmt = $this->conn->prepare($query);

		// инъекция
		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->secondname = htmlspecialchars(strip_tags($this->secondname));
		$this->login = htmlspecialchars(strip_tags($this->login));
		$this->password = htmlspecialchars(strip_tags($this->password));
		$this->gender = htmlspecialchars(strip_tags($this->gender));
		$this->location = htmlspecialchars(strip_tags($this->location));

		// привязываем значения
		$stmt->bindParam(':login', $this->login);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':secondname', $this->secondname);
		$stmt->bindParam(':gender', $this->gender);
		$stmt->bindParam(':location', $this->location);

		// для защиты пароля
		// хешируем пароль перед сохранением в базу данных
		$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
		$stmt->bindParam(':password', $password_hash);

		// Выполняем запрос
		// Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	// здесь будет метод emailExists()
}