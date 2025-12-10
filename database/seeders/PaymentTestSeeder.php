use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Payment;

class PaymentTestSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat order
        $order = Order::create([
            'order_id' => \Str::uuid(),
            'restaurant_id' => 1,
            'reservation_id' => 5, // contoh meja/reservation
            'order_type' => 'Dine In',
            'order_date' => now(),
            'status' => 'completed',
            'total_amount' => 500000,
            'notes' => 'Test payment',
        ]);

        // 2. Buat payment
        $payment = Payment::create([
            'order_id' => $order->order_id,
            'amount' => 500000,
            'status' => 'completed',
            'payment_method' => 'transfer',
            'payment_url' => 'https://example.com/payment/123',
        ]);

        $this->command->info("Dummy payment created with ID: {$payment->id}");
    }
}
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Payment;

class PaymentTestSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat order
        $order = Order::create([
            'order_id' => \Str::uuid(),
            'restaurant_id' => 1,
            'reservation_id' => 5, // contoh meja/reservation
            'order_type' => 'Dine In',
            'order_date' => now(),
            'status' => 'completed',
            'total_amount' => 500000,
            'notes' => 'Test payment',
        ]);

        // 2. Buat payment
        $payment = Payment::create([
            'order_id' => $order->order_id,
            'amount' => 500000,
            'status' => 'completed',
            'payment_method' => 'transfer',
            'payment_url' => 'https://example.com/payment/123',
        ]);

        $this->command->info("Dummy payment created with ID: {$payment->id}");
    }
}
