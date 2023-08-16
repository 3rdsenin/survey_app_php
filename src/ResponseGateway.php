<?php

class ResponseGateway
{
    private PDO $conn;
    
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }
    
    
    public function create(array $data): string
    {
        $sql = "INSERT INTO response (questionID, response)
                VALUES (:questionID, :response)";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":questionID", $data["questionID"], PDO::PARAM_INT);
        $stmt->bindValue(":response", $data["response"] ?? 0, PDO::PARAM_STR);
        
               
        $stmt->execute();
        
        return $this->conn->lastInsertId();
    }
    
    public function get(string $id): array | false
    {
        $sql = "SELECT *
                FROM response
                WHERE questionID = :id";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
        $stmt->execute();
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
                
        return $data;
    }
    
    
    
   
}











