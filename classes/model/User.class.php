<?php

/**
 * Модель пользователя
 * @author Anton Kritsky <admin@delca.ru>
 */
class User extends Model
{
    public $id = null;
    public $name = null;
    public $created_at = null;

    protected $_table = 'users';

    /**
     * Обновление хэша пользователя
     */
    public function updateHash($hash = null)
    {
        if (mb_strlen($hash) < 3) return false;
        $query = $this->_db->prepare("UPDATE {$this->_table} SET `hash`=:hash WHERE id=:id");
        $query->bindParam(":id", $this->id, PDO::PARAM_INT, 11);
        $query->bindParam(":hash", $hash, PDO::PARAM_STR, 150);
        return $query->execute();
    }

    /**
     * Получение пользователя по логину и паролю
     * @return User
     */
    public function getByLoginAndPass($login = null, $password = null)
    {
        if ($login == null or $password == null) return false;
        $query = $this->_db->prepare("SELECT * FROM {$this->_table} WHERE `name`=:login AND `password`=:password");
        $query->bindParam(":login", $login, PDO::PARAM_STR);
        $query->bindParam(":password", $password, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchObject(__CLASS__);
        return $result;
    }

    /**
     * Получение пользователя по хэшу
     */
    public function getByHash($hash = null)
    {
        $query = $this->_db->prepare("SELECT * FROM {$this->_table} WHERE `hash`=:hash");
        $query->bindParam(":hash", $hash, PDO::PARAM_STR, 150);
        $query->execute();
        $result = $query->fetchObject(__CLASS__);
        return $result;
    }

}