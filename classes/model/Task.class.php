<?php

/**
 * Модель задачи
 * @author Anton Kritsky <admin@delca.ru>
 */
class Task extends Model
{
    public $name = null;
    public $description = null;
    public $email = null;
    public $created_at = null;
    public $edited_by = null;

    protected $_table = 'tasks';

    public function add($name = null, $email = null, $description = null)
    {
        $query = $this->_db->prepare("INSERT INTO {$this->_table}
            (`name`, `email`,`description`) VALUES (:name, :email, :description)
        ");

        $query->bindParam(":name", $name, PDO::PARAM_STR, 250);
        $query->bindParam(":email", $email, PDO::PARAM_STR, 150);
        $query->bindParam(":description", $description, PDO::PARAM_STR);
        $query->execute();

        $error = $query->errorInfo();

        if (!empty($error[4])) {
            throw new Exception($$error[4]);
        }

        return $this->_db->lastInsertId();
    }

    public function update($id = null, $description = null, $userId = null)
    {

        $query = $this->_db->prepare(
            "UPDATE `{$this->_table}` SET `description` = :description, edited_by=:edited_by WHERE `id` = :id"
        );
        $query->bindParam(":id", $id, PDO::PARAM_INT, $id);
        $query->bindParam(":description", $description, PDO::PARAM_STR);
        $query->bindParam(":edited_by", $userId, PDO::PARAM_INT);
        $result = $query->execute();

        $error = $query->errorInfo();

        if (!empty($error[4])) {
            throw new Exception($$error[4]);
        }

        return $result;
    }

    public function getCount(): int
    {
        $query = $this->_db->prepare("SELECT COUNT(*) FROM {$this->_table}");
        $query->execute();

        return $query->fetchColumn();
    }

    public function done($id)
    {
        $query = $this->_db->prepare("UPDATE `{$this->_table}` SET `status` = '1' WHERE `id` = :id");
        $query->bindParam(":id", $id, PDO::PARAM_INT, $id);

        return $query->execute();
    }

    public function getAll(int $limit = null, string $order = '', int $page = null): array
    {
        $sql = "SELECT t.*, users.name as user_name FROM {$this->_table} as t
			LEFT JOIN users ON users.id = t.edited_by 
		";

        if ($order) {
            $sql .= " ORDER BY " . $order;
        }

        if (!is_null($limit)) {
            $offset = is_null($page) ? 0 : (($page - 1) * $limit);
            $sql .= " LIMIT $offset, $limit";
        }

        $query = $this->_db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function get($id = 0)
    {
        $query = $this->_db->prepare("SELECT t.*, users.name as user_name FROM {$this->_table} as t
			LEFT JOIN users ON users.id = t.edited_by 
			WHERE t.id=:id
		");
        $query->bindParam(":id", $id, PDO::PARAM_INT, 11);
        $query->execute();

        return $query->fetch(PDO::FETCH_OBJ);
    }
}