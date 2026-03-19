<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AiQuery;
use App\Models\ChatbotConversation;
use App\Services\ChatbotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    public function __construct(protected ChatbotService $chatbotService) {}

    /** Send a message to the chatbot */
    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'message'         => 'required|string|max:2000',
            'conversation_id' => 'nullable|integer|exists:chatbot_conversations,id',
            'course_id'       => 'nullable|integer|exists:courses,id',
        ]);

        $result = $this->chatbotService->processMessage(
            user:           Auth::user(),
            message:        $request->message,
            conversationId: $request->conversation_id,
            courseId:       $request->course_id,
        );

        // Log in ai_queries
        AiQuery::create([
            'user_id'   => Auth::id(),
            'course_id' => $request->course_id,
            'question'  => $request->message,
            'response'  => $result['response'],
        ]);

        return response()->json(['success' => true, 'data' => $result]);
    }

    /** Get messages in a conversation */
    public function getHistory(int $conversationId): JsonResponse
    {
        $conversation = ChatbotConversation::where('id', $conversationId)
            ->where('user_id', Auth::id())
            ->with('messages')
            ->firstOrFail();

        return response()->json(['success' => true, 'data' => $conversation]);
    }

    /** List all user conversations */
    public function getConversations(): JsonResponse
    {
        $conversations = ChatbotConversation::where('user_id', Auth::id())
            ->orderByDesc('updated_at')
            ->limit(20)
            ->get()
            ->map(function ($c) {
                return [
                    'id'         => $c->id,
                    'title'      => $c->title ?? 'Conversación',
                    'created_at' => $c->created_at->diffForHumans(),
                    'messages'   => $c->messages()->count(),
                ];
            });

        return response()->json(['success' => true, 'data' => $conversations]);
    }

    /** Delete a conversation */
    public function deleteConversation(int $id): JsonResponse
    {
        ChatbotConversation::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return response()->json(['success' => true]);
    }

    /** Rate a chatbot response */
    public function rateResponse(Request $request, int $queryId): JsonResponse
    {
        $request->validate(['helpful' => 'required|boolean']);
        AiQuery::where('id', $queryId)->where('user_id', Auth::id())
            ->update(['was_helpful' => $request->helpful]);
        return response()->json(['success' => true]);
    }
}
