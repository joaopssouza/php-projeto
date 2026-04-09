<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use App\Http\Requests\ApiFormRequest;

class UpdateProductRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'quantidade' => ['required', 'integer', 'min:0'],
            'preco' => ['required', 'numeric', 'min:0'],
        ];
    }
}
