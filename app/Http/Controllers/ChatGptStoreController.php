<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatRequest;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;

class ChatGptStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreChatRequest $request, string $id = null)
    {
        $messages = [];
        // si el id existe, entonces se obtiene el chat y se obtienen los mensajes
        if ($id) {
            $chat = Chat::findOrFail($id);
            $messages = $chat->context;
        }
        // se agrega el mensaje del usuario
        $messages[] = ['role' => 'user', 'content' => $request->input('promt')];
        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages,
        ]);
        $messages[] = ['role' => 'assistant', 'content' => $response->choices[0]->message->content];
        $chat = chat::updateOrCreate([
            'id'=>$id,
            'user_id' => Auth::id(),
        ],[
            'context' => $messages,
        ]);
        return redirect()->route('chat.show', [$chat->id]);
    }
}
