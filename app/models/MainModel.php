<?php


class MainModel extends Model
{
    //бд параметры
    private $table = 'users';
    private $table2 = 'tasks';


    // получаем tasks sort by username ASC
    public function sortByNewest() {
        //create query
        $query = 'SELECT u.id, u.login, u.email, t.body, t.status
                    FROM ' . $this->table . ' u
                    LEFT JOIN '. $this->table2 .' t ON u.id = t.user_id
                    WHERE t.body IS NOT NULL AND t.status IS NOT NULL
                    ORDER BY u.login DESC';

        //prepare statement
        $stmt = $this->db->prepare($query);

        //запускаем запрос
        $stmt->execute();

        return $stmt;
    }

    // получаем tasks sort by username with limit(pagination) ASC
    public function sortByUsernameWithLimitASC($limit, $offset) {
        //create query
        $query = 'SELECT u.login, u.email, t.body, t.status, t.id, t.updated_at
                    FROM ' . $this->table . ' u
                    LEFT JOIN '. $this->table2 .' t ON u.id = t.user_id
                    WHERE t.body IS NOT NULL AND t.status IS NOT NULL
                    ORDER BY u.login ASC , t.id ASC
                    LIMIT :limit, :offset';

        //prepare statement
        $stmt = $this->db->prepare($query);


        //подставляем данные
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        //запускаем запрос
        if ($stmt->execute()) {
            return $stmt;
        }
        //error show
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // получаем tasks sort by username DESC
    public function sortByUsernameWithLimitDESC($limit, $offset) {
        //create query
        $query = 'SELECT u.login, u.email, t.body, t.status, t.id, t.updated_at
                    FROM ' . $this->table . ' u
                    LEFT JOIN '. $this->table2 .' t ON u.id = t.user_id
                    WHERE t.body IS NOT NULL AND t.status IS NOT NULL
                    ORDER BY u.login DESC , t.id DESC
                    LIMIT :limit, :offset';

        //prepare statement
        $stmt = $this->db->prepare($query);

        //подставляем данные
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        //запускаем запрос
        if ($stmt->execute()) {
            return $stmt;
        }
        //error show
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // получаем tasks sort by Email ASC
    public function sortByEmailWithLimitASC($limit, $offset) {
        //create query
        $query = 'SELECT u.login, u.email, t.body, t.status, t.id, t.updated_at
                    FROM ' . $this->table . ' u
                    LEFT JOIN '. $this->table2 .' t ON u.id = t.user_id
                    WHERE t.body IS NOT NULL AND t.status IS NOT NULL
                    ORDER BY u.email ASC, t.id ASC
                    LIMIT :limit, :offset';

        //prepare statement
        $stmt = $this->db->prepare($query);

        //подставляем данные
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        //запускаем запрос
        if ($stmt->execute()) {
            return $stmt;
        }
        //error show
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // получаем tasks sort by Email DESC
    public function sortByEmailWithLimitDESC($limit, $offset) {
        //create query
        $query = 'SELECT u.login, u.email, t.body, t.status, t.id, t.updated_at
                    FROM ' . $this->table . ' u
                    LEFT JOIN '. $this->table2 .' t ON u.id = t.user_id
                    WHERE t.body IS NOT NULL AND t.status IS NOT NULL
                    ORDER BY u.email DESC, t.id DESC
                    LIMIT :limit, :offset';

        //prepare statement
        $stmt = $this->db->prepare($query);

        //подставляем данные
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        //запускаем запрос
        if ($stmt->execute()) {
            return $stmt;
        }
        //error show
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // получаем tasks sort by Status ASC
    public function sortByStatusWithLimitASC($limit, $offset) {
        //create query
        $query = 'SELECT u.login, u.email, t.body, t.status, t.id, t.updated_at
                    FROM ' . $this->table . ' u
                    LEFT JOIN '. $this->table2 .' t ON u.id = t.user_id
                    WHERE t.body IS NOT NULL AND t.status IS NOT NULL
                    ORDER BY t.status ASC, t.id DESC 
                    LIMIT :limit, :offset';

        //prepare statement
        $stmt = $this->db->prepare($query);

        //подставляем данные
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        //запускаем запрос
        if ($stmt->execute()) {
            return $stmt;
        }
        //error show
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // получаем tasks sort by Status DESC
    public function sortByStatusWithLimitDESC($limit, $offset) {
        //create query
        $query = 'SELECT u.login, u.email, t.body, t.status, t.id, t.updated_at
                    FROM ' . $this->table . ' u
                    LEFT JOIN '. $this->table2 .' t ON u.id = t.user_id
                    WHERE t.body IS NOT NULL AND t.status IS NOT NULL
                    ORDER BY t.status DESC, t.id DESC
                    LIMIT :limit, :offset';

        //prepare statement
        $stmt = $this->db->prepare($query);

        //подставляем данные
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        //запускаем запрос
        if ($stmt->execute()) {
            return $stmt;
        }
        //error show
        printf("Error: %s.\n", $stmt->error);
        return false;
    }


}