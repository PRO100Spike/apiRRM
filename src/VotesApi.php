<?php

require_once 'Api.php';
require_once 'Votes.php';

class VotesApi extends Api {
    public $apiName = 'votes';

    /**
     * Метод GET
     * Вывод списка всех записей
     * http://ДОМЕН/votes
     * @return string
     */
    public function indexAction() {
        $votes = Votes::getAll();

        if ($votes) {
            return $this->response((array)$votes, 200);
        }

        return $this->response('Data not found', 404);
    }

    /**
     * Метод GET
     * Просмотр отдельной записи (по id)
     * http://ДОМЕН/votes/1
     * @return string
     */
    public function viewAction() {
        //id должен быть первым параметром после /users/x
        $id = array_shift($this->requestUri);

        if ($id) {
            $vote = Votes::getById($id);

            if ($vote) {
                return $this->response($vote, 200);
            }
        }
        return $this->response('Data not found', 404);
    }

    /**
     * Метод POST
     * Создание новой записи
     * http://ДОМЕН/votes + параметры запроса
     * @return string
     */
    public function createAction() {
        return $this->response("Saving error", 500);
    }

    /**
     * Метод PUT
     * Обновление отдельной записи (по ее id)
     * http://ДОМЕН/users/1 + параметры запроса name, email
     * @return string
     */
    public function updateAction() {
        $parse_url = parse_url($this->requestUri[0]);
        $voteId = $parse_url['path'] ?? null;

        if(!$voteId || !Votes::getById($voteId)){
            return $this->response("Vote with id=$voteId not found", 404);
        }

        $input = file_get_contents('php://input');
        $requestParams = json_decode($input, true);
        $value = $requestParams['val'] ?? '';

        if($value){
            if($vorte = Votes::update($voteId, $value)){
                return $this->response('Data updated.', 200);
            }
        }

        return $this->response("Update error", 400);
    }

    /**
     * Метод DELETE
     * Удаление отдельной записи (по ее id)
     * http://ДОМЕН/users/1
     * @return string
     */
    public function deleteAction() {
        $parse_url = parse_url($this->requestUri[0]);
        $id = $parse_url['path'] ?? null;

        if (!$id || !Votes::getById($id)) {
            return $this->response("Vote with id=$id not found", 404);
        }
        if (Votes::deleteById($id)) {
            return $this->response('Data deleted.', 200);
        }
        return $this->response("Delete error", 500);
    }
}