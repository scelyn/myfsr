<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerService extends BaseService
{
    /**
     * Get paginated list of customers with optional search
     */
    public function getPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Customer::withCount(['orders'])
            ->withSum(['receivables as total_piutang' => function ($q) {
                $q->whereIn('status', ['unpaid', 'partial']);
            }], 'remaining_amount')
            ->latest();

        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('nama_toko', 'like', "%{$term}%")
                  ->orWhere('nama_pemilik', 'like', "%{$term}%")
                  ->orWhere('no_whatsapp', 'like', "%{$term}%");
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Create new customer with auto-generated code
     */
    public function createCustomer(array $data): Customer
    {
        return DB::transaction(function () use ($data) {
            return Customer::create($data);
        });
    }

    /**
     * Update existing customer data
     */
    public function updateCustomer(Customer $customer, array $data): bool
    {
        return DB::transaction(fn () => $customer->update($data));
    }

    /**
     * Soft-delete customer
     */
    public function deleteCustomer(Customer $customer): bool
    {
        return DB::transaction(fn () => $customer->delete());
    }

}
