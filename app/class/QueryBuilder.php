<?php

namespace App\Clas;

use Aura\SqlQuery\QueryFactory;
use PDO;

class QueryBuilder
{
    private $pdo;
    private $queryFactory;
    public function __construct(PDO $pdo, QueryFactory $queryFactory)
    {
        $this->pdo = $pdo;
        $this->queryFactory = $queryFactory;
    }
    public function get_ALL( $table, $data=null)
    {
        // Получить всю таблицу
        $select = $this->queryFactory->newSelect();

        $select->cols( (empty($data)) ? ['*']  : $data);
        $select->from($table);

        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function get_($id, $table, $where= null, $data = null )
    {
        $select = $this->queryFactory->newSelect();

        $select->cols((empty($data)) ? ['*']  : $data);
        $select->from($table);
        $select->where("{$where} = {$id}");
        // $select -> fromSubSelect ( 'SELECT * FROM `users` WHERE `id` = 21' );

        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function get_pages($page, $set_page, $table)
    {
        echo '<h3>Получить определенную страницу </h3>';

        $select = $this->queryFactory->newSelect();

        $select->cols(['*']);
        $select->from($table);
        $select->page($page); //какую страницу показать
        $select->setPaging($set_page); //количество записей на каждой странице


        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function Insert($data, $table)
    {
        echo '<h3>Вставляем в таблицу</h3>';

        $insert = $this->queryFactory->newInsert();

        $insert->into($table)->cols($data);

        $sth = $this->pdo->prepare($insert->getStatement());

        $sth->execute($insert->getBindValues());
    }
    // public function InsertAll($data, $table)
    // {
    //     echo '<h3>Вставляем несколько строк в таблицу</h3>';

    //     $insert = $this->queryFactory->newInsert();


    //     $insert->into($table);
    //     $insert->cols($data);
    //     $insert->addRow([
    //         'email' => '$faker->email',
    //         'password' => "123"
    //     ]);

    //     $sth = $this->pdo->prepare($insert->getStatement());

    //     $sth->execute($insert->getBindValues());
    // }
    public function update($data, $id, $table)
    {
        echo '<h3>Обновить в табл.</h3>';
        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)
            ->cols($data)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($update->getStatement());

        $sth->execute($update->getBindValues());
    }
    public function delete($id, $table)
    {
        echo '<h3>Удалить в табл.</h3>';

        $delete = $this->queryFactory->newDelete();

        $delete
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($delete->getStatement());

        $sth->execute($delete->getBindValues());
    }
    //
}
