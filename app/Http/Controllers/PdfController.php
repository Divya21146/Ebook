<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
    public function index()
    {
        $pdfs = Pdf::all();
        return view('pdfs.index', compact('pdfs'));
    }

    public function show(Pdf $pdf)
    {
        return view('pdfs.show', compact('pdf'));
    }
    public function pdfcreate()
    {
        return view('pdfs.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'pdf_file' => 'required|file|mimes:pdf|max:2048', // Validate the file
        ]);

        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $filename = $file->getClientOriginalName();
            $filepath = $file->store('pdfs', 'public'); // Store in storage/app/public/pdfs

            Pdf::create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'filename' => $filename,
                'filepath' => $filepath, // Save the relative path
            ]);

            return redirect()->route('dashboard')->with('success', 'PDF uploaded successfully!');
        }

        return back()->with('error', 'There was an error uploading the PDF.');
    }

    public function edit(Pdf $pdf)
{
    // Check if the user is an admin (you'll need to define how admins are identified)
    if (!Auth::user()) { // Replace isAdmin() with your logic
        abort(403, 'Unauthorized action.'); // Or redirect with an error message
    }

    return view('pdfs.edit', compact('pdf'));
}

public function update(Request $request, Pdf $pdf)
{
    // Check if the user is an admin
    if (!Auth::user()) {
        abort(403, 'Unauthorized action.');
    }

    $request->validate([
        'title' => 'required',
        'description' => 'nullable',
        'price' => 'required|numeric|min:0',
        // Add validation for the file if you allow updating the PDF
    ]);

    $pdf->update($request->all()); // Or update specific fields individually for safety

    return redirect()->route('dashboard')->with('success', 'PDF updated successfully!');
}

public function destroy(Pdf $pdf)
{
    // Check if the user is an admin
    if (!Auth::user()) {
        abort(403, 'Unauthorized action.');
    }

    // Delete the file from storage (optional, but recommended)
    Storage::delete('public/' . $pdf->filepath);

    $pdf->delete();

    return redirect()->route('dashboard')->with('success', 'PDF deleted successfully!');
}
    public function processPayment(Request $request)
    {
        $pdf = Pdf::findOrFail($request->pdf_id);
        $amount = $pdf->price * 100; // Amount in paisa

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {
            $order = $api->order->create([
                'receipt' => 'order_rcptid_' . time(),
                'amount' => $amount,
                'currency' => 'INR',
                'payment_capture' => 1 // Automatically capture the payment
            ]);

            $orderId = $order->id;

            // Store the order ID (optional, but recommended for later verification)
            session(['razorpay_order_id' => $orderId]);
            session(['pdf_id' => $pdf->id]); // store pdf_id in session

            return view('payment.checkout', compact('orderId', 'amount', 'pdf'));

        } catch (\Exception $e) {
            Log::error('Razorpay order creation failed: ' . $e->getMessage());
            return redirect()->route('payment.failure')->with('error', 'Payment processing error. Please try again.');
        }
    }

    public function paymentSuccess(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {
            $payment = $api->payment->fetch($request->razorpay_payment_id);
            $orderId = session('razorpay_order_id'); // Retrieve the order ID from the session

            // Verify the signature (VERY IMPORTANT)
            $attributes = array(
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $orderId,
                'razorpay_signature' => $request->razorpay_signature
            );

            $api->utility->verifyPaymentSignature($attributes); // throws Exception if invalid

            // Payment is successful, download the PDF.
            $pdfId = session('pdf_id');
            $pdf = Pdf::findOrFail($pdfId);

            // Clear the session after success
            session()->forget('razorpay_order_id');
            session()->forget('pdf_id');

            return $this->downloadPdf($pdf);

        } catch (\Exception $e) {
            // Signature verification failed, payment is fraudulent.
            Log::error('Payment verification failed: ' . $e->getMessage());  // Log the error
            return redirect()->route('payment.failure')->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    public function paymentFailure()
    {
        return view('payment.failure');
    }

    protected function downloadPdf(Pdf $pdf)
    {
        $filePath = storage_path('app/public/' . $pdf->filepath);

        Log::info("Attempting to download PDF: " . $filePath); // Add logging

        if (!file_exists($filePath)) {
            Log::error("File not found: {$filePath}"); // Log the error
            abort(404, "File not found: {$pdf->filepath}");
        }

        return response()->download($filePath, $pdf->filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}