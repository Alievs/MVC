<?php


class MainModel extends Model
{
    //бд параметры
    private $table = 'users';
    private $table2 = 'tasks';


    // получаем tasks
    public function countOfTasks() {
        //create query
        $query = 'SELECT u.id, u.login, u.email, t.body, t.status
                    FROM ' . $this->table . ' u
                    LEFT JOIN '. $this->table2 .' t ON u.id = t.user_id
                    WHERE t.body IS NOT NULL AND t.status IS NOT NULL';

        //prepare statement
        $stmt = $this->db->prepare($query);

        //запускаем запрос
        $id = null;
        if ($stmt->execute()) {
            $num = $stmt->rowCount();
            return $num;
        }
        else {
            //error show
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    // получаем tasks sort by login,Email,status with limit(pagination) ASC & DESC
    public function sortByColumnWithLimit($limit, $offset, $sort_variant, $sort_column) {
        //create query
        $query = 'SELECT u.login, u.email, t.body, t.status, t.id, t.updated_at
                    FROM ' . $this->table . ' u
                    LEFT JOIN '. $this->table2 .' t ON u.id = t.user_id
                    WHERE t.body IS NOT NULL AND t.status IS NOT NULL
                    ORDER BY '.$sort_column.' '. $sort_variant .', t.id '. $sort_variant .'
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