use App\Http\Controllers\ChatbotController;
use Illuminate\Http\Request;

Route::post('/chatbot/ask', [ChatbotController::class, 'ask']);
