<?php

namespace App\Http\Controllers\module;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\DonationReceived;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DonationResource;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'slug' => 'required',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'bank_account' => 'required|string',
            'transaction_id' => 'nullable|string',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'notes' => 'nullable|string',
        ]);

        $campaign = Campaign::where('slug', $request->slug)->first();

        if (!$campaign) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kampanye tidak ditemukan!',
            ], 404);
        }

        $donation = new Donation();
        $donation->campaign_id = $campaign->id;
        $donation->amount = $request->amount;
        $donation->payment_method = $request->payment_method;
        $donation->bank_account = $request->bank_account;

        // ✅ Buat transaction_id otomatis jika tidak dikirim dari frontend
        $donation->transaction_id = $request->transaction_id ?? 'DON-' . now()->format('Ymd-His') . '-' . strtoupper(Str::random(4));

        $donation->notes = $request->notes;

        // --- BAGIAN FILE PROOF TETAP ---
        if ($request->hasFile('payment_proof')) {
            $image = $request->file('payment_proof');
            $storagePath = Storage::disk('public')->path('payment_proofs');

            if (!is_dir($storagePath)) {
                mkdir($storagePath, 0775, true);
            }

            if (in_array(strtolower($image->extension()), ['jpg', 'jpeg', 'png'])) {
                $filename = uniqid() . '.webp';
                $path = $storagePath . '/' . $filename;

                Image::make($image)
                    ->resize(640, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->encode('webp', 80)
                    ->save($path);

                $donation->payment_proof = 'payment_proofs/' . $filename;
            } else {
                $donation->payment_proof = $image->store('payment_proofs', 'public');
            }
        }

        $donation->save();

        if (config('mail.donation_recipients')) {
            Mail::to(config('mail.donation_recipients'))
                ->send(new DonationReceived($donation, $campaign));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Donation saved successfully'
        ], 200);
    }

    public function index()
    {
        $donation = Donation::latest()->paginate(5);

        return new DonationResource(true, 'List Data Donation', $donation);
    }
}
