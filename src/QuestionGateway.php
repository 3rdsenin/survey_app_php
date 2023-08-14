<?php

class QuestionGateway
{
    private PDO $conn;
    
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }
    
    public function getAll(): array
    {
        $sql = "SELECT *
                FROM question";
                
        $stmt = $this->conn->query($sql);
        
        $data = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
            $data[] = $row;
        }
        
        return $data;
    }
    
    public function create(array $data): string
    {
        $sql = "INSERT INTO question (content, author, surveyID, type)
                VALUES (:content, :author, :surveyID, :type)";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":content", $data["content"], PDO::PARAM_STR);
        $stmt->bindValue(":author", $data["author"] ?? 0, PDO::PARAM_STR);
        $stmt->bindValue(":surveyID", $data["surveyID"] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(":type", $data["type"] ?? 0, PDO::PARAM_STR);
               
        $stmt->execute();
        
        return $this->conn->lastInsertId();
    }
    
    public function get(string $id): array | false
    {
        $sql = "SELECT *
                FROM question
                WHERE id = :id";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
        $stmt->execute();
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
                
        return $data;
    }
    
    public function update(array $current, array $new): int
    {
        $sql = "UPDATE question
                SET content = :content, author = :author, surveyID = :surveyID, type = :type
                WHERE id = :id";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":content", $new["content"] ?? $current["content"], PDO::PARAM_STR);
        $stmt->bindValue(":author", $new["author"] ?? $current["author"], PDO::PARAM_STR);
        $stmt->bindValue(":surveyID", $new["surveyID"] ?? $current["surveyID"], PDO::PARAM_INT);
        $stmt->bindValue(":type", $new["type"] ?? $current["type"], PDO::PARAM_STR);
        
        $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->rowCount();
    }
    
    public function delete(string $id): int
    {
        $sql = "DELETE FROM question
                WHERE id = :id";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->rowCount();
    }
}











