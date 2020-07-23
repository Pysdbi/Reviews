<?php

    class SQLworker
    {
        private $conn;

        public function __construct()
        {
            $this->conn = mysqli_connect('127.0.0.1', 'root', '1234', 'Reviews')
            or die('Не удалось подключится');
        }

        public function GetListReviews()
        {
            $res = mysqli_query($this->conn, 'SELECT * FROM TB_Review;');
            return $res;
        }

        public function GetReviewById($id)
        {
            $res = mysqli_query($this->conn, "SELECT * FROM TB_Review WHERE ID = $id;");
            return $res;
        }

        public function CreateReview($login, $rating, $description, $urls)
        {
            $query = "INSERT INTO TB_Review 
                        (Rating, Nickname, `Description`, URLs)
                         VALUES ($rating, '$login', '$description', '$urls');";

            mysqli_query($this->conn, $query);
        }
    }

    class JsonParser
    {
        public static function ToJson($data)
        {
            return json_encode($data);
        }
    }

    if (isset($_POST['Add']))
    {
        $Rating = $_POST['Rating'];
        $Login = $_POST['Nickname'];
        $Desc = $_POST['Description'];
        $urls = explode(', ', $_POST['Photos']);

        $db = new SQLworker();
        $db->CreateReview($Login, $Rating, $Desc, $urls);
    }
    if (isset($_GET['ShowAll']))
    {
        $db = new SQLworker();
        echo JsonParser::ToJson($db->GetListReviews());
    }
    if (isset($_GET['ShowId']))
    {
        $id = $_GET['ShowId'];
        $db = new SQLworker();
        echo JsonParser::ToJson($db->GetReviewById($id));
    }