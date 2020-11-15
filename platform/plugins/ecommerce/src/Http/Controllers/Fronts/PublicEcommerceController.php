<?php

namespace Botble\Ecommerce\Http\Controllers\Fronts;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Repositories\Interfaces\CurrencyInterface;

class PublicEcommerceController
{
    /**
     * @var CurrencyInterface
     */
    protected $currencyRepository;

    /**
     * PublicEcommerceController constructor.
     * @param CurrencyInterface $currencyRepository
     */
    public function __construct(CurrencyInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @param string $title
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function changeCurrency($title, BaseHttpResponse $response)
    {
        $currency = $this->currencyRepository->getFirstBy(['title' => $title]);

        if ($currency) {
            cms_currency()->setApplicationCurrency($currency);
        }

        return $response;
    }
}
