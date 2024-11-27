<?php

namespace App\Controllers;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\CharacterModel;

class Character extends BaseController
{
    public function index(): string
    {
        return view('pages/characters');
    }

    public function viewCharacter($charID): string
    {
        $userId = session()->get('user_id');
        $characterModel = new CharacterModel();
        $character = $characterModel->where('user_id', $userId)
                                ->where('character_id', $charID)
                               ->first();

        return view('pages/view-character', [
            'charID' => $charID,
            'character' => $character,
        ]);
    }

    public function savedCharacters(): string
    {
        return view('pages/saved-characters');
    }

    public function savedCharactersData($page)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request type.',
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $characterModel = new CharacterModel();
        $userId = session()->get('user_id');
        // Items per page
        $itemsPerPage = 10;

        // Calculate the offset
        $offset = ($page - 1) * $itemsPerPage;

        // Fetch paginated data
        $totalItems = $characterModel->where('user_id', $userId)->countAll();
        $characters = $characterModel->where('user_id', $userId)
            ->limit($itemsPerPage, $offset)
            ->get()
            ->getResultArray();

        // Count total records for pagination

        // Pass data to the view or return as JSON
        return $this->response->setJSON([
            'status' => 'success',
            'count' => $totalItems,
            'results' => $characters,
            'currentPage' => $page,
            'itemsPerPage' => $itemsPerPage,
            'totalPages' => ceil($totalItems / $itemsPerPage),
        ]);
    }

    public function saveCharacter()
    {
        // Check if the request is an AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request type.',
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $characterModel = new CharacterModel();

        // Get data from the AJAX request
        //$data = $this->request->getPost();
        $data = $this->request->getJSON(true) ?? $this->request->getPost();

        // Validate the input
        $validationRules = [
            'data'    => 'required',
        ];


        if (!$this->validate($validationRules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $this->validator->getErrors(),
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        // Save the character data
        $saveData = [
            'user_id' => session()->get('user_id'),
            'character_id'  => (int)$data['character_id'],
            'data'  => $data['data'],
        ];
            //return $this->response->setJSON([
            //    'status' => 'error',
            //    'message' => 'Validation failed.',
            //    'data' => $saveData
            //])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);

        try {
            $characterModel->save($saveData);


            session()->setFlashdata('message', 'Charactersaved for later use.');
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Charactersaved for later use.',
                'redirect' => '/characters',
            ])->setStatusCode(ResponseInterface::HTTP_OK);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to save character.',
                'error' => $e->getMessage(),
            ])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteCharacter($id)
    {
        $characterModel = new CharacterModel();
        $find = $characterModel->where('character_id', $id)
                            ->where('user_id', session()->get('user_id'))
                            ->first();

        if (!$find) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Character not found.',
                'find' => $find
            ]);
        }

        $characterModel->delete($find['id']);

        // Respond with redirect URL
        session()->setFlashdata('message', 'Character deleted from saved list.');

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Character deleted from saved list.',
            'redirect' => '/characters',
            'find' => $find
        ]);
    }
}
