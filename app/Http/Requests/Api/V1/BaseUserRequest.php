<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseUserRequest extends FormRequest
{
    public function mappedAttributes(array $additionalAttributes = [])
    {
        $attributeMap = array_merge(
            [
                'data.attributes.name' => 'name',
                'data.attributes.email' => 'email',
                'data.attributes.password' => 'password',
                'data.attributes.isManager' => 'is_manager',
            ],
            $additionalAttributes
        );

        $attributesToOperate = [];

        foreach ($attributeMap as $key => $attribute) {
            if ($this->has($key)) {
                $value = $this->input($key);

                if ($attribute == 'password') {
                    $value = bcrypt($value);
                }

                $attributesToOperate[$attribute] = $value;
            }
        }

        return $attributesToOperate;
    }

    public function messages()
    {
        return [
            'data.attributes.status' => 'The data.attributes.status valus is invalid.Please use A,C,H or X.',
        ];
    }
}
