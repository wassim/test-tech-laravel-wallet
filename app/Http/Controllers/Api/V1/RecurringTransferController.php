<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\CreateRecurringTransfer;
use App\Http\Requests\Api\V1\StoreRecurringTransferRequest;
use Illuminate\Http\Request;

class RecurringTransferController
{
    public function index(Request $request)
    {
        $recurringTransfers = $request->user()
            ->recurringTransfers()
            ->latest()
            ->get();

        return response()->json(['data' => $recurringTransfers]);
    }

    public function store(StoreRecurringTransferRequest $request, CreateRecurringTransfer $createRecurringTransfer)
    {
        $recurringTransfer = $createRecurringTransfer->execute($request->validated());

        return response()->json([
            'data' => $recurringTransfer,
        ]);
    }

    public function destroy(Request $request, int $id)
    {
        $recurringTransfer = $request()->user()->recurringTransfers()->findOrFail($id);

        $recurringTransfer->delete();

        return response()->json('ok');
    }
}
