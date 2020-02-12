<?php

require_once CORE_PATH . 'DataBase.php';

class CreateModel extends Model
{
    //бд параметры
    private $table = 'users';
    private $table2 = 'tasks';

    //create task
    public function createTaskWithNewUser($login, $email, $body, $password, $role_id)
    {

        //create query user
        $query = 'INSERT INTO ' . $this->table . ' 
                  SET
                  login = :login,
                  password = :password,
                  email = :email,
                  role_id = :role_id';

        //create query task
        $query2 = 'INSERT INTO ' . $this->table2 . '
                    SET
                    user_id = :user_id,
                    body = :body,
                    status = 0';

//-----------------------QUERY 1--------------------------------------------------------------------
        //prepare statement
        $stmt = $this->db->prepare($query);

        //подставляем данные
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role_id', $role_id);

        //запускаем запрос
        $stmt->execute();


//-----------------------QUERY 2--------------------------------------------------------------------
        //prepare statement
        $stmt2 = $this->db->prepare($query2);

        //достаём юзера
        $last_id = $this->db->lastInsertId();


        //подставляем данные
        $stmt2->bindParam(':body', $body);
        $stmt2->bindParam(':user_id', $last_id);

        //запускаем запрос 2
        if ($stmt2->execute()) {
            return true;
        }

        //error show
        printf("Error: %s.\n", $stmt->error);

        return false;
//        //create query
//        $query = 'SELECT
//                    t.id,
//                    t.u_id,
//                    t.body,
//                    t.status,
//                    u.name,
//                    u.email
//                  FROM'. $this->table. 't
//                  LEFT JOIN
//                    users u ON t.u_id = u.id';
    }

    //create task with existing user
    public function createTask($user_id, $body)
    {
        //create query task
        $query = 'INSERT INTO ' . $this->table2 . '
                    SET
                    user_id = :user_id,
                    body = :body,
                    status = 0';

        //prepare statement
        $stmt = $this->db->prepare($query);

        //подставляем данные
        $stmt->bindParam(':body', $body);
        $stmt->bindParam(':user_id', $user_id);

        //запускаем запрос
        if ($stmt->execute()) {
            return true;
        }

        //error show
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    //check existing user in db
    public function checkUser($login, $email)
    {
        //проверяем существование user'a  в базе
        $check = 'SELECT id
                  FROM ' . $this->table . ' WHERE login = :login AND email = :email';

        //prepare statement
        $stmtchk = $this->db->prepare($check);
        
        //подставляем данные
        $stmtchk->bindParam(':login', $login);
        $stmtchk->bindParam(':email', $email);

        //запускаем запрос
        $id = null;
        if ($stmtchk->execute()) {
            $value = $stmtchk->fetch(PDO::FETCH_OBJ);
            if (is_object($value)) {
                $id = $value->id;

                return $id;
            }

        } else {
            //error show
            printf("Error: %s.\n", $stmtchk->error);

            return false;
        }


    }
}