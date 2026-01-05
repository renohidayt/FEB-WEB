<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'pesan' => 'required',
        ]);

        $data = [
            'nama'  => $request->nama,
            'email' => $request->email,
            'pesan' => $request->pesan,
        ];

        // 2. Kirim Email
        // Masukkan email tujuan (email admin FEB)
        Mail::to('220660121005@student.unsap.ac.id')->send(new ContactMail($data));

        // 3. Kembali dengan pesan sukses
        return back()->with('success', 'Pesan Anda telah berhasil dikirim ke email kami!');
    }
}