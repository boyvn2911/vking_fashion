<?php

namespace Botble\Ecommerce\Tables;

class OrderIncompleteTable extends OrderTable
{

    /**
     * @var bool
     */
    protected $hasCheckbox = false;

    /**
     * {@inheritDoc}
     */
    protected function tableActions($item)
    {
        return $this->getOperations('orders.view-incomplete-order', null, $item);
    }

    /**
     * {@inheritDoc}
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $select = [
            'ec_orders.id',
            'ec_orders.status',
            'ec_orders.user_id',
            'ec_orders.created_at',
            'ec_orders.amount',
            'ec_orders.currency_id',
            'ec_orders.shipping_amount',
            'ec_orders.payment_id',
        ];

        $query = $model
            ->select()
            ->with(['user', 'payment'])
            ->where('ec_orders.is_finished', 0);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model, $select));
    }

    /**
     * {@inheritDoc}
     */
    public function renderTable($data = [], $mergeData = [])
    {
        if ($this->query()->count() === 0 &&
            !$this->request()->wantsJson() &&
            $this->request()->input('filter_table_id') !== $this->getOption('id')
        ) {
            return view('plugins/ecommerce::orders.incomplete-intro');
        }

        return parent::renderTable($data, $mergeData);
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
        return [];
    }
}
