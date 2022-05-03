<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

/**
 * Controller class for Entity Transaction
 * 
 * @var Transaction $transaction - Transaction object for Injection Model Pattern
 * @var Illuminate\Database\Eloquent\Collection $transactions - Collection object with all transactions containing columns: 'uuid', 'title', 'value' and 'type'
 * @var array $balance - Associative array containing 'income', 'outcome' and 'total'
 * @var integer $total - Total sum of income and outcome
 * 
 * @method public  index() - Return the list with transactions and balance
 * @method public  show(string $uuid) - Return a transaction refered by uuid
 * @method public  store(Request $request) - Persists a transaction object on database
 * @method public  update(Request $request, string $uuid) - Alter a transaction refered by uuid
 * @method public  destroy(string $uuid) - Delete a transaction refered by uuid
 * @method private setTransactions() - Set the transactions array list
 * @method private setBalance() - Calculate income, outcome and total and sets the balance and total variables 
 * @method private updateHasChanges(Transaction|Collection $transaction, array $post) - Check whether the request values differs from previous transaction
 * @method private responseError(string $errMsg, integer $httpCode) - Return a Response informing that the id doesn't exist
 * 
 */
class TransactionController extends Controller
{

    /**
     * Transaction object for Injection Model Pattern
     * 
     * @var Transaction
     */
    private $transaction;

    /**
     * Collection object with all transactions containing columns: 'uuid', 'title', 'value' and 'type'
     * 
     * @var Illuminate\Database\Eloquent\Collection
     */
    private $transactions;

    /**
     * Associative array containing 'income', 'outcome' and 'total'
     * 
     * @var array
     */
    private $balance;

    /**
     * Total sum of income and outcome
     * 
     * @var integer
     */
    private $total;

    /**
     * TransactionController constructor
     * 
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->setTransactions();
        $this->setBalance();
    }

    /**
     * @source Swagger OpenAPI documentation
     * @see 'http://localhost:8000/api/documentation'
     * 
     * @OA\get(
     *     path="/api/transactions",
     *     tags={"Transactions"},
     *     summary="Get transaction's list",
     *     description="Return a list with all transactions and balance",
     *     operationId="index",
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(ref="#/components/schemas/List")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         @OA\JsonContent(ref="#/components/responses/500")
     *     )
     * ),
     * 
     * @method Returns a list with transactions and balance
     * 
     * @return Response|json
     */
    public function index()
    {
        return response()->json(array(
            'transactions' => $this->transactions,
            'balance'      => $this->balance
        ), 200);
    }

    /**
     * @source Swagger OpenAPI documentation
     * @see 'http://localhost:8000/api/documentation'
     * 
     * @OA\get(
     *     path="/api/transactions/{uuid}",
     *     tags={"Transactions"},
     *     summary="",
     *     description="",
     *     operationId="show",
     *     @OA\Parameter(ref="#components/parameters/Uuid"),
     *     @OA\Response(
     *         response=200,
     *         @OA\JsonContent(ref="#/components/responses/200")
     *     ),
     *     @OA\Response(
     *         response=404
     *         @OA\JsonContent(ref="#/components/responses/404")
     *     ),
     *     @OA\Response(
     *         response=500
     *         @OA\JsonContent(ref="#/components/responses/500")
     *     )
     * ),
     * 
     * @method Return a transaction refered by uuid
     * 
     * @param  string $uuid
     * 
     * @return Response|json
     */
    public function show($uuid)
    {
        $transaction = $this->transactions->find($uuid);

        if ($transaction === null)
            return $this->responseError();

        return response()->json($transaction, 200);
    }

    /**
     * @source Swagger OpenAPI documentation
     * @see 'http://localhost:8000/api/documentation'
     * 
     * @OA\post(
     *     path="/api/transactions",
     *     tags={"Transactions"},
     *     summary="",
     *     description="",
     *     operationId="store",
     *     @OA\RequestBody(ref="#/components/requestBodies/TransactionForm"),
     *     @OA\Response(
     *         response=200,
     *         @OA\JsonContent(ref="#/components/responses/200")
     *     ),
     *     @OA\Response(
     *         response=400
     *         description=""
     *     ),
     *     @OA\Response(
     *         response=500
     *         @OA\JsonContent(ref="#/components/responses/500")
     *     )
     * ),
     * 
     * @method Persists a transaction object on database
     * 
     * @param  Request $request
     * 
     * @return Response|json
     */
    public function store(Request $request)
    {
        $post = $request->all();
        extract($post);

        if ($type == 'outcome' and $value > $this->total)
            return $this->responseError('balance exceeded', 400);

        $request->validate(
            $this->transaction->rules(),
            $this->transaction->feedback()
        );

        $transaction = $this->transaction->create($post);

        return response()->json($transaction, 201);
    }

    /**
     * @source Swagger OpenAPI documentation
     * @see 'http://localhost:8000/api/documentation'
     * 
     * @OA\put(
     *     path="/api/transactions/{uuid}",
     *     tags={"Transactions"},
     *     summary="",
     *     description="",
     *     operationId="update",
     *     @OA\Parameter(ref="#components/parameters/Uuid"),
     *     @OA\RequestBody(ref="#/components/requestBodies/TransactionForm"),
     *     @OA\Response(
     *         response=200,
     *         @OA\JsonContent(ref="#/components/responses/200")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         @OA\JsonContent(ref="#/components/responses/404")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         @OA\JsonContent(ref="#/components/responses/422")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         @OA\JsonContent(ref="#/components/responses/500")
     *     )
     * ),
     * @OA\patch(
     *     path="/api/transactions/{uuid}",
     *     tags={"Transactions"},
     *     summary="",
     *     description="",
     *     operationId="update",
     *     @OA\Parameter(ref="#components/parameters/Uuid"),
     *     @OA\RequestBody(ref="#/components/requestBodies/TransactionForm"),
     *     @OA\Response(
     *         response=200,
     *         @OA\JsonContent(ref="#/components/responses/200")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         @OA\JsonContent(ref="#/components/responses/404")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         @OA\JsonContent(ref="#/components/responses/422")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         @OA\JsonContent(ref="#/components/responses/500")
     *     )
     * ),
     * 
     * @method Alter a transaction refered by uuid
     * 
     * @param  Request $request
     * @param  string  $uuid
     * 
     * @return Response|json
     */
    public function update(Request $request, $uuid)
    {
        $transaction = $this->transactions->find($uuid);

        if ($transaction === null)
            return $this->responseError();

        $dinamicRules = [];

        $post = $request->all();
        extract($post);

        if (empty($post))
            return $this->responseError('nothing to update, no values inserted', 422);

        if (!$this->updateHasChange($transaction, $post))
            return $this->responseError('nothing to update, equal values', 422);

        if (isset($type) and isset($value) and $type == 'outcome' and $value > $this->total)
            return $this->responseError('not allowed, balance exceeded', 400);

        if ($request->method() === 'PATCH') {
            foreach ($this->transaction->rules() as $key => $value)
                if (array_key_exists($key, $post))
                    $dinamicRules[$key] = $value;
        } else {
            $dinamicRules = $this->transaction->rules();
        }

        $request->validate($dinamicRules, $this->transaction->feedback());

        $transaction->update($post);

        return response()->json($transaction, 200);
    }

    /**
     * @source Swagger OpenAPI documentation
     * @see 'http://localhost:8000/api/documentation'
     * 
     * @OA\delete(
     *     path="/api/transactions/{uuid}",
     *     tags={"Transactions"},
     *     summary="",
     *     description="",
     *     operationId="destroy",
     *     @OA\Parameter(ref="#components/parameters/Uuid"),
     *     @OA\Response(
     *         response=200,
     *         @OA\JsonContent(ref="#/components/responses/200")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         @OA\JsonContent(ref="#/components/responses/404")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         @OA\JsonContent(ref="#/components/responses/500")
     *     )
     * ),
     * 
     * @method Delete a transaction refered by uuid
     * 
     * @param  string $uuid
     * 
     * @return Response|json
     */
    public function destroy($uuid)
    {
        $transaction = $this->transactions->find($uuid);

        if ($transaction === null)
            return $this->responseError();

        if ($this->transaction->find($uuid)->delete())
            return response()->json($transaction, 200);
    }

    /**
     * Set the transactions array list
     * 
     */
    private function setTransactions()
    {
        $this->transactions = $this->transaction->all(['uuid', 'title', 'value', 'type', 'created_at', 'updated_at']);
    }

    /**
     * Calculate income, outcome and total and sets the balance and total variables 
     * 
     */
    private function setBalance()
    {
        $this->balance = array_reduce($this->transactions->toArray(), function ($balance, $transaction) {
            if ($transaction['type'] == 'income') {
                $balance['income'] += $transaction['value'];
                $balance['total']  += $transaction['value'];
                return $balance;
            }
            if ($transaction['type'] == 'outcome') {
                $balance['outcome'] += $transaction['value'];
                $balance['total']   -= $transaction['value'];
                return $balance;
            }
        }, array(
            'income'  => 0,
            'outcome' => 0,
            'total'   => 0
        ));

        $this->total = $this->balance['total'];
    }

    /**
     * Check whether the request values differs from previous transaction
     * 
     * @param  Transaction|Collection $transaction
     * @param  array $post
     * 
     * @return boolean
     */
    private function updateHasChange($transaction, $post)
    {
        foreach ($transaction->toArray() as $key => $value)
            if (isset($post[$key]) and $post[$key] != $value)
                return true;
        return false;
    }

    /**
     * Return a Response informing that the id doesn't exist
     * 
     * @param  string $errMsg
     * @param  integer $httpCode
     * 
     * @return Response|json
     */
    private function responseError($errMsg = 'resource not found', $httpCode = 404)
    {
        return response()->json(array(
            'error' => $errMsg
        ), $httpCode);
    }
}
