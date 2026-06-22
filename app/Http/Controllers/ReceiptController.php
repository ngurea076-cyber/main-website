<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
class ReceiptController extends Controller {
    public function __invoke(Order $order) { return Pdf::loadView('pdf.receipt',compact('order'))->download('receipt-'.$order->reference.'.pdf'); }
}
