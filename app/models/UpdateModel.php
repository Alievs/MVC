<?php

class UpdateModel extends Model
{

    //бд параметры
    private $table = 'users';
    private $table2 = 'tasks';

    public function getOneTask($id)
    {
        //create query
        $query = 'SELECT u.login, u.email, t.body, t.status, t.id
                    FROM ' . $this->table . ' u
                    LEFT JOIN '. $this->table2 .' t ON u.id = t.user_id
                    WHERE t.id = :task_id';

        //prepare statement
        $stmt = $this->db->prepare($query);

        //подставляем данные
        $stmt->bindParam(':task_id', $id, PDO::PARAM_INT);

        //запускаем запрос
        if ($stmt->execute()) {
            return $stmt;
        }
        //error show
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    //check if body was changed
    public function checkBody($id)
    {
        $query = 'SELECT body
                   FROM '. $this->table2 . '
                   WHERE id = :id';

        // Prepare statement
        $stmt = $this->db->prepare($query);

        // Bind data
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        //запускаем запрос
        if ($stmt->execute()) {
            return $stmt;
        }
        //error show
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function updateWithOutBody($id, $status)
    {
        // Create query
        $query = 'UPDATE ' . $this->table2 . '
                  SET status = :status
                  WHERE id = :id';

        // Prepare statement
        $stmt = $this->db->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($id));
        $this->status = htmlspecialchars(strip_tags($status));

        // Bind data
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);

        //запускаем запрос
        if ($stmt->execute()) {
            return $stmt;
        }
        //error show
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Update Task
    public function update($id, $body, $status) {

        // Create query
        $query = 'UPDATE ' . $this->table2 . '
                  SET status = :status, body = :body, updated_at = CURRENT_TIME
                  WHERE id = :id';

        // Prepare statement
        $stmt = $this->db->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($id));
        $this->body = htmlspecialchars(strip_tags($body));
        $this->status = htmlspecialchars(strip_tags($status));

        // Bind data
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':body', $body);
        $stmt->bindParam(':id', $id);

        //запускаем запрос
        if ($stmt->execute()) {
            return $stmt;
        }
        //error show
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

}