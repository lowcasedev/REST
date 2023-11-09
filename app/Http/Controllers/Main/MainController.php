<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class MainController extends Controller
{

    /**
     * @OA\PathItem(path="/notebook")
     */
    public function index()
    {
        $user = User::find(session()->get('user'));
        $notes = $user->notes;
        return view('welcome', ['notes' => $notes]);
    }

    public function showNote($id)
    {
        $data = Note::find($id);
        return view('welcome', ['notes' => $data]);
    }

    /**
     * @OA\Post(
     *     path="/notebook/add",
     *     summary="adds a new note",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="note",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer"
     *                 ),
     *                 example={"title" : "TODO LIST", "note" : "i should flower the plants", "user_id" : 1}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     *  )
     */
    public function addNote(Request $request)
    {
        Note::create
        ([
            'title' => $request->input('title'),
            'note' => $request->input('note'),
            'user_id' => session()->get('user'),
        ]);

        return redirect('/');
    }

    /**
     * @OA\Delete(
     *     path="/notebook/delete/{id}",
     *     summary="deletes a note",
     *     @OA\Parameter(
     *         description="ID",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="First user id."),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function deleteNote($id)
    {
        $note = Note::find($id);

        $note?->delete();

        return redirect('/notebook');

    }

    public function getNote($id)
    {
        return Note::find($id);
    }

    /**
     * @OA\Put(
     *     path="/notebook/update/{id}",
     *     summary="updates a note",
     *          @OA\Parameter(
     *          description="ID",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="string"),
     *          @OA\Examples(example="int", value="1", summary="First user id."),
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="note",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer"
     *                 ),
     *                 example={"title" : "TODO LIST", "note" : "i should flower the plants", "user_id" : 1}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     *  )
     */
    public function updateNote(Request $request, $id)
    {
        $note = Note::find($id);
        $note->update
        ([
            'title' => $request->input('title'),
            'note' => $request->input('note'),
        ]);

        return redirect('/');
    }
}
