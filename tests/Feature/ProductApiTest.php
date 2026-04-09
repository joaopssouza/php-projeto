<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_200_with_products_list(): void
    {
        Product::query()->create([
            'nome' => 'Teclado',
            'quantidade' => 10,
            'preco' => 199.90,
        ]);

        Product::query()->create([
            'nome' => 'Mouse',
            'quantidade' => 25,
            'preco' => 89.50,
        ]);

        $response = $this->getJson('/api/products');

        $response
            ->assertStatus(200)
            ->assertJsonPath('message', 'Produtos listados com sucesso.')
            ->assertJsonCount(2, 'data');
    }

    public function test_store_returns_201_and_persists_product(): void
    {
        $payload = [
            'nome' => 'Monitor',
            'quantidade' => 5,
            'preco' => 1299.99,
        ];

        $response = $this->postJson('/api/products', $payload);

        $response
            ->assertStatus(201)
            ->assertJsonPath('message', 'Produto criado com sucesso.')
            ->assertJsonPath('data.nome', 'Monitor')
            ->assertJsonPath('data.quantidade', 5);

        $this->assertDatabaseHas('products', [
            'nome' => 'Monitor',
            'quantidade' => 5,
        ]);
    }

    public function test_store_returns_422_when_payload_is_invalid(): void
    {
        $response = $this->postJson('/api/products', [
            'nome' => '',
            'quantidade' => null,
            'preco' => null,
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', 'Falha de validacao.')
            ->assertJsonValidationErrors(['nome', 'quantidade', 'preco']);
    }

    public function test_update_returns_200_for_existing_product(): void
    {
        $product = Product::query()->create([
            'nome' => 'Headset',
            'quantidade' => 12,
            'preco' => 349.90,
        ]);

        $response = $this->putJson('/api/products/'.$product->id, [
            'nome' => 'Headset Pro',
            'quantidade' => 9,
            'preco' => 399.90,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('message', 'Produto atualizado com sucesso.')
            ->assertJsonPath('data.nome', 'Headset Pro')
            ->assertJsonPath('data.quantidade', 9);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'nome' => 'Headset Pro',
            'quantidade' => 9,
        ]);
    }

    public function test_update_returns_404_when_product_does_not_exist(): void
    {
        $response = $this->putJson('/api/products/999999', [
            'nome' => 'Inexistente',
            'quantidade' => 1,
            'preco' => 10.00,
        ]);

        $response
            ->assertStatus(404)
            ->assertJsonPath('message', 'Produto nao encontrado.');
    }

    public function test_destroy_returns_200_for_existing_product(): void
    {
        $product = Product::query()->create([
            'nome' => 'Webcam',
            'quantidade' => 7,
            'preco' => 299.00,
        ]);

        $response = $this->deleteJson('/api/products/'.$product->id);

        $response
            ->assertStatus(200)
            ->assertJsonPath('message', 'Produto removido com sucesso.')
            ->assertJsonPath('data.id', $product->id);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    public function test_destroy_returns_404_when_product_does_not_exist(): void
    {
        $response = $this->deleteJson('/api/products/999999');

        $response
            ->assertStatus(404)
            ->assertJsonPath('message', 'Produto nao encontrado.');
    }
}
