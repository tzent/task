<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Handler\Interfaces\TransactionHandlerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    /**
     * @var TransactionHandlerInterface
     */
    private TransactionHandlerInterface $transactionHandler;

    public function __construct(TransactionHandlerInterface $transactionHandler)
    {
        $this->transactionHandler = $transactionHandler;
    }

    public function all(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(['source']), [
            'source' => ['required', Rule::in(['db', 'csv'])]
        ]);

        if ($validator->fails()) {
            return response()->json(
                data: ['error' => $validator->errors()->first()],
                status: Response::HTTP_BAD_REQUEST
            );
        }

        $transactions = $this->transactionHandler->getTransactionsList($request->query(key: 'source'));

        return $this->transactionHandler->hasErrors()
            ? response()->json(
                data: ['error' => $this->transactionHandler->getFirstError()],
                status: Response::HTTP_BAD_REQUEST
            )
            : response()->json(data: $transactions);
    }
}
