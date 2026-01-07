<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class PastikanMejaTerpilih
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1) meja harus dipilih
        if (!$request->session()->has('meja_id')) {
            return redirect()
                ->route('pelanggan.scan')
                ->with('pesan', 'Silahkan Scan QR Code meja terlebih dahulu.');
        }

        // 2) token tamu wajib ada (anti IDOR)
        $tokenTamu = $request->cookie('token_tamu') ?? $request->session()->get('token_tamu');

        // kalau belum ada, buat token baru
        if (!$tokenTamu) {
            $tokenTamu = (string) Str::uuid();
        }

        // sinkronkan ke session (biar stabil di server)
        $request->session()->put('token_tamu', $tokenTamu);
        cookie()->queue(cookie(
            name: 'token_tamu',
            value: $tokenTamu,
            minutes: 60 * 24 * 30,
            path: '/',
            domain: null,
            secure: $request->isSecure(),
            httpOnly: true,
            raw: false,
            sameSite: 'Lax'
        ));

        return $next($request);
    }
}
