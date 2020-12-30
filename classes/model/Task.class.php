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

    public function update($id = null, $description = null)
    {

        $query = $this->_db->prepare("UPDATE `{$this->_table}` SET `description` = :description WHERE `id` = :id");
        $query->bindParam(":id", $id, PDO::PARAM_INT, $id);
        $query->bindParam(":description", $description, PDO::PARAM_STR);
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
}