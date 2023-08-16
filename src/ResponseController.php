<?php

class ResponseController
{
    public function __construct(private ResponseGateway $gateway)
    {
    }
    
    public function processRequest(string $method, ?string $id): void
    {
        if ($id) {
           
             $this->processCollectionRequest($method,  $id);
            
        } else {
            
            http_response_code(404);
            exit;
        }
    }
    
    // private function processResourceRequest(string $method, string $id): void
    // {
    //     $question = $this->gateway->get($id);
        
    //     switch ($method) {
    //         case "GET":                     
    //             if ( ! $question) {
    //                 http_response_code(404);
    //                 echo json_encode(["message" => "Question not found"]);
    //             } 
    //             echo json_encode($question);           
    //             break;
                
            
                
    //         default:
    //             http_response_code(405);
    //             header("Allow: GET, POST");
    //     }
    // }
    
    private function processCollectionRequest(string $method, string $id): void
    {
        switch ($method) {
            case "GET":
                   
                    $data = $this->gateway->get($id);
                        if ($data === false) {
                            echo json_encode(["message" => "No response found"]);
                        }else {
                            echo json_encode([$data]);
                        }                
                break;
                
            case "POST":
                
                 $data = (array) json_decode(file_get_contents("php://input"), true);
                
                 $errors = $this->getValidationErrors($data);
                
                 if ( ! empty($errors)) {
                     http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                 }
               
                 $id = $this->gateway->create($data);
                
                http_response_code(201);
                echo json_encode([
                    "message" => "Response created",
                    "id" => $id
                ]);
                break;
            
            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }
    
    private function getValidationErrors(array $data, bool $is_new = true): array
    {
        $errors = [];
        
        if ($is_new && empty($data["questionID"])) {
            $errors[] = "questionID is required";
        }
        
        if ($is_new && empty($data["response"])) {
            $errors[] = "response is required";
        }

        return $errors;
    }
}









