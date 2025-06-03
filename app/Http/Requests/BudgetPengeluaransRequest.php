<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BudgetPengeluaransRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->get('id'); // ini akan terisi saat update

        return [
            'bulan' => [
                'required',
                'integer',
                'min:1',
                'max:12',
            ],
            'tahun' => [
                'required',
                'integer',
                'min:2000',
                'max:2100',
            ],
            'jumlah' => [
                'required',
                'numeric',
                'min:0',
            ],
            // Validasi kombinasi unik bulan & tahun
            // Jika update, abaikan ID sendiri
            'bulan' => [
                'required',
                'integer',
                'min:1',
                'max:12',
                function ($attribute, $value, $fail) use ($id) {
                    $bulan = request('bulan');
                    $tahun = request('tahun');

                    $exists = \App\Models\BudgetPengeluarans::where('bulan', $bulan)
                        ->where('tahun', $tahun)
                        ->when($id, fn($q) => $q->where('id', '!=', $id))
                        ->exists();

                    if ($exists) {
                        $fail("Budget untuk bulan dan tahun tersebut sudah ada.");
                    }
                }
            ]
        ];
    }

    

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
