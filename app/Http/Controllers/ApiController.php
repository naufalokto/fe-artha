<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{

    private $api = 'http://localhost:9090';

    public function signup(Request $request)
{
    $client = new \GuzzleHttp\Client([
        'base_uri' => 'http://localhost:9090/',
        'timeout' => 10,
        'verify' => false
    ]);
    
    try {
        $response = $client->post('signup', [
            'json' => [
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'username' => $request->username,
                'password' => $request->password
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
        
        return response()->json(
            json_decode($response->getBody()->getContents()),
            $response->getStatusCode()
        );
        
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Gagal terhubung ke API Go',
            'error' => $e->getMessage(),
            'detail' => 'Pastikan endpoint /signup tersedia di API Go'
        ], 500);
    }
}
public function login(Request $request)
{
    try {
        // Log request data
        \Log::info('Login attempt received', [
            'email' => $request->email,
            'request_data' => $request->all(),
            'api_url' => $this->api . '/login'
        ]);
        
        // Validasi input
        if (!$request->email || !$request->password) {
            \Log::warning('Login attempt failed: Missing credentials', [
                'has_email' => (bool)$request->email,
                'has_password' => (bool)$request->password
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Email dan password harus diisi'
            ], 422);
        }
        
        // Buat HTTP client dengan konfigurasi yang benar
        $client = new \GuzzleHttp\Client([
            'base_uri' => $this->api,
            'timeout' => 30,
            'verify' => false,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);

        \Log::info('Sending request to backend', [
            'url' => $this->api . '/login',
            'email' => $request->email
        ]);

        // Kirim request menggunakan Guzzle
        $response = $client->post('/login', [
            'json' => [
                'email' => $request->email,
                'password' => $request->password
            ]
        ]);
        
        // Get response body
        $body = $response->getBody()->getContents();
        
        // Log raw response
        \Log::info('Backend response received', [
            'status' => $response->getStatusCode(),
            'body' => $body
        ]);

        // Parse JSON response
        $data = json_decode($body, true);
        
        \Log::info('Parsed response data', [
            'status_code' => $response->getStatusCode(),
            'has_token' => isset($data['token']),
            'has_role' => isset($data['role']),
            'role' => $data['role'] ?? 'unknown'
        ]);

        if ($response->getStatusCode() === 200 && isset($data['token'])) {
            \Log::info('Login successful', [
                'email' => $data['email'] ?? $request->email,
                'role' => $data['role'] ?? 'unknown'
            ]);

            // Simpan data user dan token ke session
            session([
                'user' => [
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'role' => $data['role']
                ],
                'jwt_token' => $data['token']
            ]);

            \Log::info('Session data saved', [
                'session' => [
                    'has_user' => session()->has('user'),
                    'has_token' => session()->has('jwt_token'),
                    'user_role' => session('user')['role'] ?? 'missing'
                ]
            ]);

            // Tentukan redirect URL berdasarkan role
            $role = strtolower($data['role'] ?? '');
            $redirectUrl = match($role) {
                'admin' => '/admin/dashboard',
                'manager' => '/manager/dashboard',
                'sales' => '/sales/dashboard',
                'customer' => '/customer',
                default => '/'
            };

            \Log::info('Redirecting user', [
                'role' => $role,
                'redirect_url' => $redirectUrl
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'redirect' => $redirectUrl,
                'user' => [
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'role' => $data['role']
                ]
            ], 200);
        }

        // Handle error response
        $errorMessage = $data['message'] ?? 'Login gagal. Silakan cek email dan password Anda.';
        
        \Log::error('Login failed', [
            'status_code' => $response->getStatusCode(),
            'error_response' => $body
        ]);

        return response()->json([
            'status' => 'error',
            'message' => $errorMessage
        ], $response->getStatusCode());

    } catch (\GuzzleHttp\Exception\ConnectException $e) {
        \Log::error('Backend connection error', [
            'message' => $e->getMessage(),
            'api_url' => $this->api . '/login'
        ]);
        
        return response()->json([
            'status' => 'error',
            'message' => 'Tidak dapat terhubung ke server. Pastikan backend server berjalan.'
        ], 503);
    } catch (\Exception $e) {
        \Log::error('Unexpected login error', [
            'message' => $e->getMessage(),
            'class' => get_class($e),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan pada server. Silakan coba lagi.'
        ], 500);
    }
}
    public function midtransWebhook(Request $request)
    {
        // Implementasi webhook midtrans
    }

    // ADMIN
    public function createAccount(Request $request)
    {
        // Implementasi create account admin
    }

    // SALES
    public function insertProductAndStock(Request $request)
    {
        // Implementasi insert produk dan stok
    }

    public function updateProductStock(Request $request)
    {
        // Implementasi update stok produk
    }

    public function insertRawMaterial(Request $request)
    {
        // Implementasi insert raw material
    }

    public function getRawMaterialsSorted(Request $request)
    {
        // Implementasi get raw materials sorted
    }

    // MANAGER
    public function analyzeAllProducts(Request $request)
    {
        // Implementasi analisa produk
    }

    public function salesRecap(Request $request)
    {
        // Implementasi sales recap
    }

    // CUSTOMER
    public function viewTransaction(Request $request)
    {
        // Implementasi view transaksi customer
    }

    public function checkout(Request $request)
    {
        // Implementasi checkout
    }

    public function addToCart(Request $request)
    {
        // Implementasi tambah ke cart
    }

    public function getUserCart(Request $request)
    {
        // Implementasi get user cart
    }

    public function deleteCartItems(Request $request)
    {
        // Implementasi hapus item cart
    }
}