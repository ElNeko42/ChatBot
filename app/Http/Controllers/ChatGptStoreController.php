<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatRequest;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ChatGptStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreChatRequest $request, string $id = null)
    {
        if (!$id) {
            // **Crear un nuevo chat**
            $role = $request->input('role', 'Asistente General');

            // Definir el mensaje de sistema basado en el rol
            switch ($role) {
                case 'Recepcionista de Hotel':
                    $systemMessage = "Eres un recepcionista de hotel. Solo puedes manejar consultas relacionadas con reservas, servicios del hotel, información sobre habitaciones, etc. Si se te pregunta sobre temas fuera de tu ámbito, debes indicar que no puedes ayudar.";
                    break;
                case 'Soporte Técnico':
                    $systemMessage = "Eres un asistente de soporte técnico. Solo puedes ayudar con problemas relacionados con tecnología, dispositivos, software, etc. Si se te pregunta sobre otros temas, debes indicar que no puedes ayudar.";
                    break;
                default:
                    $systemMessage = "Eres un asistente general que puede ayudar con cualquier consulta.";
                    break;
            }

            // Inicializar el contexto con el mensaje de sistema
            $messages = [
                ['role' => 'system', 'content' => $systemMessage],
            ];

            // Crear el chat, incluyendo 'role'
            $chat = Chat::create([
                'user_id' => Auth::id(),
                'context' => $messages,
                'role' => $role,
            ]);

            // Redirigir al nuevo chat
            return redirect()->route('chat.show', [$chat->id]);
        } else {
            // **Actualizar un chat existente**
            $chat = Chat::findOrFail($id);
            $messages = $chat->context;

            // Agregar el mensaje del usuario
            $userMessage = ['role' => 'user', 'content' => $request->input('promt')];
            $messages[] = $userMessage;

            // Solicitar respuesta a OpenAI
            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => $messages,
            ]);

            // Agregar la respuesta del asistente
            $assistantMessage = ['role' => 'assistant', 'content' => $response->choices[0]->message->content];
            $messages[] = $assistantMessage;

            // Actualizar el chat con el nuevo contexto
            $chat->update([
                'context' => $messages,
            ]);

            // Redirigir de nuevo al chat
            return redirect()->route('chat.show', [$chat->id]);
        }
    }
}
