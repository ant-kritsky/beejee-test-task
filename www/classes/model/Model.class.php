<?php

/**
 * Базовый класс модели
 * @author Anton Kritsky <admin@delca.ru>
 */
class Model
{
    public $id = null;

    protected $_db = null;
    protected $_table = null;

    protected static $_instance;

    public function __construct()
    {
        $this->_db = Core::getInstance()->getDb();

        return $this;
    }

    /**
     * Удаляет запись
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $query = $this->_db->prepare("DELETE FROM `{$this->_table}` WHERE `id` = :id");
        $query->bindParam(":id", $id, PDO::PARAM_INT, $id);

        return $query->execute();
    }

    public function get($id = 0)
    {
        $query = $this->_db->prepare("SELECT {$this->_table}.* FROM {$this->_table} WHERE id=:id");
        $query->bindParam(":id", $id, PDO::PARAM_INT, 11);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Возвращает массив объектов записей
     *
     * @param int|null $limit
     * @param string $order
     * @param int|null $page
     * @return array
     */
    public function getAll(int $limit = null, string $order = '', int $page = null): array
    {
        $sql = "SELECT {$this->_table}.* FROM {$this->_table}";

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

    public static function getInstance()
    {
        if (empty(self::$_instance)) {
            self::$_instance = new static();
        }

        return self::$_instance;
    }

}