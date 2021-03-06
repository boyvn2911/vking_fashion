<?php

namespace Botble\Payment\Http\Requests;

use Botble\Support\Http\Requests\Request;

class PayPalPaymentCallbackRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount'    => 'required|numeric',
            'currency'  => 'required',
            'paymentId' => 'required|min:6',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        $messages = parent::messages();

        $messages['paymentId.required'] = __('Payment failed!');

        return $messages;
    }
}
