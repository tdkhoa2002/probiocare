<?php

namespace Modules\Wallet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\UpdateBalanceOnHold;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Jobs\JobSendFeeClaim;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Wallet\Repositories\CurrencyAttrRepository;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Wallet\Repositories\WalletChainRepository;
use Modules\Wallet\Repositories\TransactionRepository;
use Modules\Wallet\Repositories\BlockchainRepository;
use Modules\Wallet\Repositories\ChainWalletRepository;

class WebHookController extends BaseApiController
{
    protected $currencyRepository;
    protected $currencyAttrRepository;
    protected $walletRepository;
    protected $walletChainRepository;
    protected $transactionRepository;
    protected $blockchainRepository;
    protected $chainWalletRepository;
    public function __construct(
        CurrencyRepository $currencyRepository,
        CurrencyAttrRepository $currencyAttrRepository,
        WalletRepository $walletRepository,
        WalletChainRepository $walletChainRepository,
        TransactionRepository $transactionRepository,
        BlockchainRepository $blockchainRepository,
        ChainWalletRepository $chainWalletRepository
    ) {
        $this->currencyRepository = $currencyRepository;
        $this->currencyAttrRepository = $currencyAttrRepository;
        $this->walletRepository = $walletRepository;
        $this->walletChainRepository = $walletChainRepository;
        $this->transactionRepository = $transactionRepository;
        $this->blockchainRepository = $blockchainRepository;
        $this->chainWalletRepository = $chainWalletRepository;
    }

    public function hookDeposit(Request $request)
    {
        try {
            $dataRequest = $request->all();
            \Log::channel('deposit')->info($dataRequest);
            $chainCode = $dataRequest['chainCode'] ?? null;
            $tokenAddress = $dataRequest['tokenAddress'] ?? null;
            $from = $dataRequest['from'] ?? null;
            $to = $dataRequest['to'] ?? null;
            $value = $dataRequest['value'] ?? null;
            $transactionHash = $dataRequest['transactionHash'] ?? null;
            $blockNumber = $dataRequest['blockNumber'] ?? null;

            if ($chainCode != null && $from != null && $to != null && $value != null && $transactionHash != null && $blockNumber != null) {
                $checkSendFee = $this->chainWalletRepository->findChainWalletByAddress($from);
                $checkWithdrawInternal = $this->transactionRepository->findByAttributes([
                    'txhash' => $transactionHash,
                    'action' => TypeTransactionActionEnum::WITHDRAW
                ]);
                if ($checkSendFee && !$checkWithdrawInternal) {
                    return $this->respondWithError('From address is wallet send');
                }
                $blockchain = $this->blockchainRepository->findByAttributes(['code' => $chainCode]);
                if ($blockchain) {
                    $currencyAttr = $this->currencyAttrRepository->findByAttributes(['blockchain_id' => $blockchain->id, 'token_address' => $tokenAddress, 'status' => true]);
                    if ($currencyAttr) {
                        if ($currencyAttr->type_deposit == 'ONCHAIN') {
                            $walletChain = $this->walletChainRepository->findByAttributes(['address' => $to, 'blockchain_id' => $blockchain->id]);
                            if ($walletChain) {
                                $walletCustomer = $walletChain->wallet;
                                $wallet = $this->walletRepository->findByAttributes(['customer_id' => $walletCustomer->customer_id, 'currency_id' => $currencyAttr->currency_id]);
                                if ($wallet) {
                                    $checkDeposit = $this->transactionRepository->findByAttributes([
                                        'customer_id' => $wallet->customer_id,
                                        'txhash' => $transactionHash,
                                        'action' => TypeTransactionActionEnum::DEPOSIT
                                    ]);
                                    if ($checkDeposit) {
                                        \Log::channel('deposit')->error('WebHookController - hookDeposit: Transaction hash executed');
                                        return $this->respondWithError('Transaction hash executed');
                                    }
                                    $currency = $currencyAttr->currency;
                                    $decimal = 10 ** $currencyAttr->decimal;
                                    $valueDecimal = $value / $decimal;
                                    if ($valueDecimal > 0) {
                                        $newBalance = $wallet->balance + $valueDecimal;
                                        $transaction = [
                                            'customer_id' => $wallet->customer_id,
                                            'currency_id' => $currencyAttr->currency_id,
                                            'blockchain_id' => $currencyAttr->blockchain_id,
                                            'action' => TypeTransactionActionEnum::DEPOSIT,
                                            'amount' => $valueDecimal,
                                            'amount_usd' => $valueDecimal * $currency->usd_rate,
                                            'fee' => 0,
                                            'balance' => $newBalance,
                                            'balanceBefore' => $wallet->balance,
                                            'payment_method' => 'CRYPTO',
                                            'txhash' => $transactionHash,
                                            'from' => $from,
                                            'to' => $to,
                                            'tag' => "",
                                            'order' => 0,
                                            'note' => "",
                                            'status' => StatusTransactionEnum::COMPLETED
                                        ];
                                        $this->transactionRepository->create($transaction);
                                        $totalOnhold = $walletChain->onhold + $valueDecimal;
                                        event(new UpdateBalanceOnHold($totalOnhold,  $wallet->id, $currencyAttr->blockchain_id));
                                        event(new UpdateBalanceWallet($newBalance, $wallet->id));
                                        if ($totalOnhold > $currency->min_crawl && $tokenAddress != "" && $tokenAddress != null) {
                                            JobSendFeeClaim::dispatch($blockchain, $walletChain->address, $currencyAttr->decimal);
                                        }
                                        return $this->respondWithSuccess('Deposit success');
                                    } else {
                                        \Log::channel('deposit')->error('WebHookController - hookDeposit: Deposit fail, value < 0');
                                        return $this->respondWithError('Deposit fail, value < 0');
                                    }
                                } else {
                                    $dataCreate = [
                                        'customer_id' =>  $walletCustomer->customer_id,
                                        'currency_id' => $currencyAttr->currency_id,
                                        'type' => 'CRYPTO',
                                        'balance' => 0,
                                        'status' => true,
                                    ];
                                    $wallet = $this->walletRepository->create($dataCreate);
                                    $dataCreateWallet = [
                                        'wallet_id' => $wallet->id,
                                        'blockchain_id' => $blockchain->id,
                                        'address' => $walletChain->address,
                                        'addressTag' => "",
                                        'private_key' => $walletChain->private_key,
                                        'onhold' => 0
                                    ];
                                    $this->walletChainRepository->create($dataCreateWallet);
                                    return $this->hookDeposit($request);
                                }
                            } else {
                                \Log::channel('deposit')->error('WebHookController - hookDeposit: wallet customer not found');
                                return $this->respondWithError('Wallet customer not found');
                            }
                        } else {
                            \Log::channel('deposit')->error('WebHookController - hookDeposit: Currency not support deposit');
                            return $this->respondWithError('Currency not support deposit');
                        }
                    } else {
                        \Log::channel('deposit')->error('WebHookController - hookDeposit: Currency not support deposit');
                        return $this->respondWithError('Currency not support deposit');
                    }
                } else {
                    \Log::channel('deposit')->error('WebHookController - hookDeposit: Blockchain not found');
                    return $this->respondWithError('Blockchain not found');
                }
            } else {
                \Log::channel('deposit')->error($dataRequest);
                return $this->respondWithError('data not found');
            }
        } catch (\Exception $e) {
            \Log::channel('deposit')->error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function hookWithdraw(Request $request)
    {
        try {
            $dataRequest = $request->all();
            \Log::channel('withdraw')->info($dataRequest);
            if ($dataRequest['transactionId'] == null || $dataRequest['status'] == null) {
                return $this->respondWithError('data dont enough');
            }

            $transaction = $this->transactionRepository->findByAttributes([
                'id' => $dataRequest['transactionId'],
                'action' => TypeTransactionActionEnum::WITHDRAW,
                'status' => StatusTransactionEnum::PROCESSING
            ]);
            if ($transaction) {
                if ($dataRequest['status'] == 'success') {
                    $this->transactionRepository->update($transaction, ['status' => StatusTransactionEnum::COMPLETED, 'txhash' => $dataRequest['hash']]);
                }
                if ($dataRequest['status'] == 'fail') {
                    $this->transactionRepository->update($transaction, ['status' => StatusTransactionEnum::FAIL]);
                }
            } else {
                \Log::channel('withdraw')->error('transaction not found');
                return $this->respondWithError('transaction not found');
            }
        } catch (\Exception $e) {
            \Log::channel('withdraw')->error($e->getMessage());
        }
    }
}
