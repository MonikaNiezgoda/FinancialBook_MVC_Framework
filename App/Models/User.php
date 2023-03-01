<?php

namespace App\Models;

use PDO;
use \App\Token;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{

    public $errors = [];

    /**
     * Class constructor
     *
     * @param array $data  Initial property values (optional)
     *
     * @return void
     */
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    /**
     * Save the user model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */
    public function save()
    {
        $this->validate();

        if (empty($this->errors)) {

            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users
                    VALUES (NULL, :username, :password_hash, :email)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':username', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            

            return $stmt->execute();
        }

        return false;
    }

    /**
     * Validate current property values, adding valiation error messages to the errors array property
     *
     * @return void
     */
    public function validate()
    {
        // Name
        if ($this->name == '') {
            $this->errors[] = 'Imię jest wymagane';
        }

        // email address
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Nieprawidłowy email';
        }
        if (static::emailExists($this->email)) {
            $this->errors[] = 'Na podany email już istnieje konto';
        }

        // Password
        if (strlen($this->password) < 6) {
            $this->errors[] = 'Hasło nie może być krótsze niż 6 znaków';
        }

        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
            $this->errors[] = 'Hasło musi zawierać minimum jedną literę';
        }

        if (preg_match('/.*\d+.*/i', $this->password) == 0) {
            $this->errors['e3_pass'] = 'Hasło musi zawierać minimum jedną cyfrę';
        }
    }

    public  function validatePassword()
    {
        if (strlen($this->newPassword) < 6) {
           $this-> errors[] = 'Hasło nie może być krótsze niż 6 znaków';
        }

        if (preg_match('/.*[a-z]+.*/i', $this->newPassword) == 0) {
            $this-> errors[] = 'Hasło musi zawierać minimum jedną literę';
        }

        if (preg_match('/.*\d+.*/i', $this->newPassword) == 0) {
            $this-> errors['e3_pass'] = 'Hasło musi zawierać minimum jedną cyfrę';
        }
        else return true;
    }
    public static function emailExists($email)
    {
        return static::findByEmail($email) !== false;
    }

    public static function findByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function authenticate($email, $password)
    {
        $user = static::findByEmail($email);

        if ($user) {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }

        return false;
    }

    public static function findByID($id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }
    public function rememberLogin()
    {
        $token = new Token();
        $hashed_token = $token->getHash();

        $expiry_timestamp = time() + 60 * 60 * 24 * 30;  // 30 days from now

        $sql = 'INSERT INTO remembered_logins (token_hash, user_id, expires_at)
                VALUES (:token_hash, :user_id, :expires_at)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $expiry_timestamp), PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function changePassword()
    {
        $this->validatePassword();

        if (empty($this->errors))
        {
            $id=$this->id;
            $password_hash = password_hash($this->newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE users
                    SET password = :password_hash
                    WHERE id = '$id'";

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);           

            return $stmt->execute();
        }
        else return false;
    }
   
}
