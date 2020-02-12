<?php

class LoginModel extends Model
{
    private $table = 'users';


    //check existing user in db
    public function checkUserInDB($login, $password)
    {
        //query for checking user in db
        $query = 'SELECT *
                  FROM ' . $this->table . ' 
                  WHERE login = :login AND password = :password';

        //prepare statement
        $stmt = $this->db->prepare($query);

        //hashed password
        $password = md5($password);

        //подставляем данные
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);

        //execute query
        $id = null;
        if ($stmt->execute()) {
            $value = $stmt->fetch(PDO::FETCH_OBJ);
            if (is_object($value) && $value !== null) {
//                return user data
                $user = array(
                    "role_id" => $value->role_id,
                    "login" => $value->login
                );
                return $user;
            }

        } else {
            //error show
            printf("Error: %s.\n", $stmt->error);

            return false;
        }


    }

}