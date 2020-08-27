<?php
    class Database{
        private $servername = 'localhost';
        private $username = 'root';
        private $password = "";
        private $dbname = 'line_queue';
        
        public function connection(){
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }

        public function addToQueue($COUNT, $REASON, $SERVICED){
            // This function will be called from reception.php
            $conn = $this->connection();
            try {            
                $sql = "INSERT INTO queue (id, reason, serviced, window)
                VALUES (?, ?, ?, -1);";
                $query = $conn->prepare($sql);
                $query->execute([$COUNT, $REASON, $SERVICED]);
               // echo "Added number ". $COUNT . " to queue." . "<br>"; 
            } catch(Exception $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
    
        }

        public function removeFromQueue($COUNT){
            // This will be called from manage.php
            $conn = $this->connection();
            try{
                $sql = "DELETE FROM queue WHERE id=?;";
                $query = $conn->prepare($sql);
                $query->execute([$COUNT]);
                //echo "Removed number ". $COUNT . " from queue." . "<br>"; 
            } catch(Exception $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
        }
    
    }
?>