<?php

class Votes {

    private  $id;
    private  $url;
    private  $count;
    private  $value;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getCount() {
        return $this->count;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    private function getQweryResult ($query) {
        return $query->fetchAll(PDO::FETCH_CLASS, "Votes");
    }

    public function getAll() {
        $result = [];
        $db = new PDO('sqlite:db.sqlite', "", "", array(
            PDO::ATTR_PERSISTENT => true
        ));

        $query = $db->query('SELECT * FROM votes');

        foreach (self::getQweryResult($query) as $votes) {
            $vote['id'] = $votes->getId();
            $vote['ulr'] = $votes->getUrl();
            $vote['count'] = $votes->getCount();
            $vote['value'] = $votes->getValue();

            $result[]= $vote;
        }

        return $result;
    }

    public function getById($id) {
        $db = new PDO('sqlite:db.sqlite', "", "", array(
            PDO::ATTR_PERSISTENT => true
        ));

        $query = $db->query('SELECT * FROM votes WHERE id ="' . $id . '"');

        $results = self::getQweryResult($query);

        foreach ($results as $votes) {
            $vote['id'] = $votes->getId();
            $vote['ulr'] = $votes->getUrl();
            $vote['count'] = $votes->getCount();
            $vote['value'] = $votes->getValue();

            return $vote;
        }

        return null;
    }

    public function deleteById($id){
        $db = new PDO('sqlite:db.sqlite', "", "", array(
            PDO::ATTR_PERSISTENT => true
        ));

        return $db->exec('DELETE from votes WHERE id="' . $id . '"');
    }

    public function update($id, $value) {

        $vote = self::getById($id);
        $vote['count']++;
        $vote['value'] = ($vote['value'] + $value) / 2;

        $db = new PDO('sqlite:db.sqlite', "", "", array(
            PDO::ATTR_PERSISTENT => true
        ));

        return $db->exec('UPDATE votes SET count="' . $vote['count'] . '", value="' . $vote['value'] . '"  WHERE id = "' . $id . '"');
    }

}