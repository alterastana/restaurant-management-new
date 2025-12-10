use App\Http\Controllers\WebhookController;

Route::post('/webhook/payment', [WebhookController::class, 'handlePayment']);
