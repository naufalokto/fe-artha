<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
    $client = new \GuzzleHttp\Client([
        'base_uri' => 'http://localhost:9090/',
        'timeout' => 10,
        'verify' => false,
        'http_errors' => false
    ]);
    
    try {
        $response = $client->post('login', [
            'json' => [
                'email' => $request->email,
                'password' => $request->password
            ],
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);

        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody()->getContents(), true);

        if ($statusCode !== 200) {
            return response()->json([
                'message' => $responseBody['message'] ?? 'Login failed',
                'errors' => $responseBody['errors'] ?? [],
                'status' => $statusCode
            ], $statusCode);
        }

        return response()->json($responseBody, 200);
        
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to connect to API Go',
            'error' => $e->getMessage()
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