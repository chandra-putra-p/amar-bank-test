<?php

namespace Controllers;

use Models\Loan;
use services\LoanService;
use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};
use Utils\ResponseUtil;
use Utils\LoggerUtil;
use Validators\Validator;

class LoanController
{
    private $loanService;
    private $logger;
    private $validator;
    public function __construct(LoanService $loanService, Validator $validator)
    {
        $this->loanService = $loanService;
        $this->validator = $validator;
        $this->logger = new LoggerUtil('loanController');
    }

    public function create(Request $request, Response $response)
    {
        // try {
            $requestBody = $request->getParsedBody();
            $this->logger->info("Request body", ["body" => $requestBody]);

            $validationResult = $this->validator->validate($requestBody);

            if (!$validationResult['isValid']) {
                $this->logger->warning('Validation failed', [
                    'data' => $requestBody,
                    'errors' => $validationResult['errors']
                ]);

                $response->getBody()->write(json_encode([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validationResult['errors']
                ]));

                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(400);
            }

            // $obj = json_decode($requestBody);
            $this->logger->info("Request obj", ["obj" => $requestBody]);
            $loan = new Loan(
                $requestBody->name,
                $requestBody->ktpNumber,
                $requestBody->loanAmount,
                $requestBody->loanPeriod,
                $requestBody->loanPurpose,
                $requestBody->dob,
                $requestBody->gender,
            );
            $this->logger->info("loan dob", ["loan" => $loan->dob]);

            $res = $this->loanService->create($loan);
            $this->logger->warning("res", ["res" => $res]);

            return ResponseUtil::json($response, "Loan created successfully", $res, 201);
        // } catch (\Throwable $e) {
        //     return ResponseUtil::json($response, $e->getMessage(), 500);
        // }
    }
}
