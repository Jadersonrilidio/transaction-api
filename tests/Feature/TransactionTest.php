<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Unit tests class for Transaction and TransactionController classes
 * 
 * @var string $testUuid - Transaction uuid created on test_store()
 * 
 * @method public test_api_index() - Test if the GET index() route returns http code 200 and a JSON list
 * @method public test_api_store() - Test if the POST store() route creates a transaction and returns an object|JSON transaction with http code 201
 * @method public test_api_show() - Test if the GET show() route returns http code 200 with an JSON transaction
 * @method public test_api_put() - Test if the PUT update() route returns http code 200 and the updated object|JSON transaction
 * @method public test_api_patch() - Test if the PATCH update() route returns http code 200 and the updated object|JSON transaction
 * @method public test_api_delete() - Test if the DELETE destroy() route returns http code 200 and the deleted object|JSON transaction
 * @method public test_should_be_able_to_list_the_transactions() - Application alllows to create a transaction and return a JSON with the transaction data as response
 * @method public test_should_be_able_to_list_the_transactions() - Application allows to return an Object|JSON with all transactions and the balance
 * @method public test_should_not_be_able_to_create_outcome_transaction_without_a_valid_balance() - Application de not allows to create a transaction of type outcome exceeds the total in balance, and return a Response http code 400 and a message in the format Response|Json { error: string }
 * 
 */
class TransactionTest extends TestCase
{

    /**
     * Transaction uuid created on test_store()
     * @var string
     */
    private static $testUuid;

    /**
     * Test if the GET index() route returns http code 200 and a JSON list
     * 
     */
    public function test_api_index()
    {
        $response = $this->get('/api/transactions');
        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                array(
                    'transactions' => array(
                        '*' => array(
                            'uuid',
                            'title',
                            'value',
                            'type',
                            'created_at',
                            'updated_at'
                        )
                    ),
                    'balance' => array(
                        'income',
                        'outcome',
                        'total'
                    )
                )
            );
    }

    /**
     * Test if the POST store() route creates a transaction and returns an object|JSON transaction with http code 201
     * 
     */
    public function test_api_store()
    {
        $response = $this->post('/api/transactions', array(
            'title' => 'old store unit test',
            'value' => 1000,
            'type'  => 'income'
        ));

        self::$testUuid = $response['uuid'];

        $response
            ->assertStatus(201)
            ->assertJsonStructure(
                [
                    'uuid', 'created_at', 'updated_at', 'title', 'value', 'type'
                ]
            );
    }

    /**
     * Test if the GET show() route returns http code 200 with an JSON transaction
     * 
     */
    public function test_api_show()
    {
        $response = $this->get('/api/transactions/' . self::$testUuid);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'uuid', 'title', 'value', 'type', 'created_at', 'updated_at'
                ]
            );
    }

    /**
     * Test if the PUT update() route returns http code 200 and the updated object|JSON transaction
     * 
     */
    public function test_api_put()
    {
        $response = $this->put('/api/transactions/' . self::$testUuid, array(
            'title' => 'update test title',
            'value' => 2000,
            'type'  => 'income'
        ));

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'uuid', 'title', 'value', 'type', 'created_at', 'updated_at'
                ]
            );
    }

    /**
     * Test if the PATCH update() route returns http code 200 and the updated object|JSON transaction
     * 
     */
    public function test_api_patch()
    {
        $response = $this->patch('/api/transactions/' . self::$testUuid, array(
            'value' => 1000,
            'type'  => 'outcome'
        ));

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'uuid', 'title', 'value', 'type', 'created_at', 'updated_at'
                ]
            );
    }

    /**
     * Test if the DELETE destroy() route returns http code 200 and the deleted object|JSON transaction
     * 
     */
    public function test_api_delete()
    {
        $response = $this->delete('/api/transactions/' . self::$testUuid);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'uuid', 'title', 'value', 'type', 'created_at', 'updated_at'
                ]
            );
    }

    /**
     * Application alllows to create a transaction and return a JSON with the transaction data as response
     * 
     * Alias for test_api_store()
     * 
     */
    public function test_should_be_able_to_create_a_new_transaction()
    {
        $response = $this->postJson('/api/transactions', array(
            'title' => 'new store unit test',
            'value' => 1000,
            'type'  => 'income'
        ));

        $response
            ->assertStatus(201)
            ->assertJsonStructure(
                [
                    'uuid', 'created_at', 'updated_at', 'title', 'value', 'type'
                ]
            );
    }

    /**
     * Application allows to return an Object|JSON with all transactions and the balance
     * 
     * Alias for test_api_index()
     * 
     */
    public function test_should_be_able_to_list_the_transactions()
    {
        $response = $this->getJson('/api/transactions');

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                array(
                    'transactions' => array(
                        '*' => array(
                            'uuid',
                            'title',
                            'value',
                            'type',
                            'created_at',
                            'updated_at'
                        )
                    ),
                    'balance' => array(
                        'income',
                        'outcome',
                        'total'
                    )
                )
            );
    }

    /**
     * Application de not allows to create a transaction of type outcome exceeds the total in balance, and return a Response http code 400 and a message in the format Response|Json { error: string }
     * 
     */
    public function test_should_not_be_able_to_create_outcome_transaction_without_a_valid_balance()
    {
        $list = $this->getJson('/api/transactions');
        $exceedValue = $list['balance']['total'] + 1;

        $response = $this->postJson('/api/transactions', array(
            'title' => 'any for test',
            'value' => $exceedValue,
            'type'  => 'outcome'
        ));

        $response
            ->assertStatus(400)
            ->assertJson(array(
                'error' => true
            ));
    }
}
