namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class ReturnController extends Controller
{
    public function showReturnPage($order_id)
    {
        $order = Order::findOrFail($order_id);
        return view('returns', compact('order'));
    }
public function processReturn(Request $request, $order_id)
{
    $request->validate([
        'reason' => 'required|string|max:500',
    ]);

    // Process return request (save in database or notify admin)
    \DB::table('order_returns')->insert([
        'order_id' => $order_id,
        'reason' => $request->reason,
        'status' => 'pending',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('previous-orders')->with('status', 'Return request submitted successfully!');
}
public function returnProduct($product_id)
{
    $product = Product::findOrFail($product_id);
    
    return view('return-page', compact('product'));
}

}
